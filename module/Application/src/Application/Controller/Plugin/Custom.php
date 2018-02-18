<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;
use Facebook\Facebook;
use Zend\Di\Di;
use Zend\Di\Config;



class Custom extends AbstractPlugin

{
    protected $di;
    
    public function confDi()
    {
        if($this->di == null)
        {
            $this->di = new Di();
        }
      
        $config = $this->getController()->getServiceLocator()->get('config');
        $di_conf= new Config($config['di_tables']);
        $this->di->configure($di_conf);
        return $this->di;
    }
    
    public function confDiPaging()
    {
        if($this->di == null)
        {
            $this->di = new Di();
        }
        $config = $this->getController()->getServiceLocator()->get('config');
        $di_conf= new Config($config['di_paging']);
        $this->di->configure($di_conf);
        
        return $this->di;
    }
    
    
    public function getKategorije()
    {
        $di=$this->confDi();
        $katTable = $di ->get('Application\Model\KategorijaTable', array('table'=>'kategorija'));
        $kategorija = $katTable->fetchAll();
        $selectData = array();
    
        foreach ($kategorija as $kat) {
            $selectData[$kat ->id_kat] = $kat->naziv_kat ;
        }
    
        return $selectData;
    }
    
    public function getViewModel()
    {
        $form1 = $this->getController()->getServiceLocator()->get('SelectForm');
        $select = $this->getKategorije();
        $auth = $this->getController()->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
        $di=$this->confDi();
        $faceTable = $di ->get('Application\Model\FacebookTable', array('table'=>'facebook'));
        $grupe = $faceTable->fetchAll();
        
        return new ViewModel(array('select'=>$form1, 'kat'=>$select, 'korisnik'=>$storage['korisnik'], 'face'=>$grupe
        ));
    }
    
    public function getFileUploadLocation()
    {
        $config = $this->getController()->getServiceLocator()->get('config');
        return $config['module_config']['upload_location'];
    }
    
}