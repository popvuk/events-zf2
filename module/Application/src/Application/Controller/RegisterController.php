<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Korisnik;


class RegisterController extends AbstractActionController
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
       $form = $this->getServiceLocator()->get('RegisterForm');
 
       $model = $custom->getViewModel();
       $model->setVariables(array('form' =>$form));
       return $model;
    }
    
    public function processAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        if (!$this->request->isPost())
        {
            return $this->notFoundAction();
        }
        
        $post = $this->request->getPost();      
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->setData($post);
         
        if (!$form->isValid())
        {
            $model = $custom->getViewModel();
            $model->setVariables(array('form' =>$form, 'error'=>true));
            $model->setTemplate('application/register/index');
            return $model;
        }
        
        $korisnik = new Korisnik();
        $korisnik->exchangeArray($form->getData());
              
        try
        {
            $korisnikTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
            $korisnikTable->createKorisnik($korisnik);
        }
        catch (\Exception $ex)
        {
            $model = $custom->getViewModel();
            $model->setVariables(array('form' =>$form, 'error1'=>true));
            $model->setTemplate('application/register/index');
            return $model;
        }
        
        return $this->redirect()->toRoute(NULL ,array( 
            'controller' => 'register', 
            'action' =>  'confirm'
        ));
    }
    
    public function confirmAction()
    {
        $custom = $this->getCustom();
        $model = $custom->getViewModel();
        return $model;
    }
  
}