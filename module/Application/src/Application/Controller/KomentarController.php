<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Application\Model\Komentar;
use Zend\Di\Config;

class KomentarController extends AbstractActionController
{

    protected $custom;
    
    public function getCustom()
    {
        if($this->custom == null)
        {
            $this->custom = $this->Custom();
        }
        
        return $this->custom;
    }
    
    public function indexAction()
    {
        $custom = $this->getCustom();
        $auth = $this->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
        $korime = $storage['korisnik'];
        $id = $this->params()->fromRoute('id');
        if($korime != null)
        {
            $form = $this->getServiceLocator()->get('KomentarForm');
            $model = $custom->getViewModel();
            $model->setVariables(array('form'=>$form,'id'=>$id));
            return $model;
        }
        $fm = new FlashMessenger();
        $config = $this->getServiceLocator()->get('config');
        $fm->addMessage($config['messages']['komentar_error']);
        return $this->forward()->dispatch('Application\Controller\Post',
            array('action' => 'index', 'id' => $id));
    }
    
    public function createkomAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        if(!$this->request->isPost())
        {
            return $this->notFoundAction();
        }
    
        $form = $this->getServiceLocator()->get('KomentarForm');
        $post = $this->request->getPost();
        $form->setData($post);
    
        if(!$form->isValid())
        {
            $model = $custom->getViewModel();
            $model->setVariables(array('form'=>$form,'id'=>$this->params()->fromRoute('id'),'error'=>true));
            $model->setTemplate('application/komentar/index');
            return $model;
        }
    
        $auth = $this->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
    
        $data = array();
        $data['id_post'] = $this->params()->fromRoute('id');
        $data['korime'] = $storage['korisnik'];
        $data['komentar'] = $this->getRequest()->getPost('komentar');
    
        $komentar = new Komentar();
    
        $komentar->exchangeArray($data);
    
    
        $config = $this->getServiceLocator()->get('config');
    
        $di_conf= new Config($config['di_tables']);
        $di->configure($di_conf);
         
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
    
        $komTable->createKomentar($komentar);
    
        return $this->redirect()->toRoute('application/post',
            array('action' =>'index', 'id'=>$this->params()->fromRoute('id')));
    }
    
}