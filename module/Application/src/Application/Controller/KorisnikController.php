<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Post;
//use Zend\Paginator\Paginator;
//use Zend\Paginator\Adapter\Iterator;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

/**
 * KorisnikController
 *
 * @author popvuk
 *
 * @version 1.0
 *
 */
class KorisnikController extends AbstractActionController
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
        $di=$custom->confDi();
        $auth = $this->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
        
        if($storage['rola'] == 'administrator')
        {
             return $this->redirect()->toRoute('application/admin', array(
    		     'action' =>  'index'));
        }
      
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $posts = $postTable->getPostsByKorime($storage['korisnik']);
        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
        
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$posts->buffer()));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(5)
                  ->setPageRange(5);
        
        $form = $this->getServiceLocator()->get('PostForm');

        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form,'posts'=>$paginator, 'flashMessages' => $this->flashMessenger()->getMessages(), 'action'=>'index'));
        return $model;
    }
    
    public function addpostAction()
    {
        $custom = $this->getCustom();
        $form = $this->getServiceLocator()->get('PostForm');
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form));
        return $model;      
    }
    
    public function createpostAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $request = $this->getRequest();       
        $auth = $this->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
        $korime = $storage['korisnik'];
        
        if ($request->isPost())
        {
         	$data = array_merge_recursive(
         			$this->getRequest()->getPost()->toArray(),
         			$this->getRequest()->getFiles()->toArray()
    	     );
         	
         	$form = $this->getServiceLocator()->get('PostForm');
    		$form->setData($data);
    		
     		if (!$form->isValid()) 
    	    {
    	    	$model = $custom->getViewModel();
    	    	$model->setVariables(array('error' => true,'form'  => $form));
    		    $model->setTemplate('application/korisnik/addpost');
    		    return $model;  	
    		 }   					 
    		 
    		 $post = new Post();
    	     $fajl = $this->params()->fromFiles('slika');
    	       		
    	     $putanja = $custom->getFileUploadLocation();
    	     
    	     $korisnikTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
    	     $korisnik = $korisnikTable->getKorisnikByKorime($korime);

    	     $exchange_data = array();
    		 $exchange_data['slika'] = $fajl['name'];
    		 $exchange_data['id_korisnik'] = $korisnik->id;
    		 $exchange_data['id_kat'] = $this->getRequest()->getPost('id_kat');
    		 $exchange_data['naslov'] = $this->getRequest()->getPost('naslov');
    		 $data = new \DateTime(date('m.d.y'));
			 $zone = new \DateTimeZone('Europe/Belgrade');
			 $dat = new \DateTime();
			 $dat->setTimezone($zone);
    		 $format = $dat->format('Y-m-d');   		    
    		 $exchange_data['dat_objave'] = $format; 		    
    		 $data = new \DateTime($this->getRequest()->getPost('dat_od'));
    		 $format = $data->format('Y-m-d');		    
    		 $exchange_data['dat_od'] = $format;  		    
    		 $data = new \DateTime($this->getRequest()->getPost('dat_do'));
    		 $format = $data->format('Y-m-d');  		    
    		 $exchange_data['dat_do'] = $format;
    		 $exchange_data['vreme'] = $this->getRequest()->getPost('vreme');
    		 $exchange_data['lokacija'] = $this->getRequest()->getPost('lokacija');
    		 $exchange_data['tekst'] = $this->getRequest()->getPost('tekst');
    				
    		 $post->exchangeArray($exchange_data);
    				
    		 $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
    		 $id = $postTable->createPost($post);
    		 
    		 $files   = $this->getRequest()->getFiles();
    		 $filter = new  \Zend\Filter\File\RenameUpload($putanja.'/'.$id.'-'.$fajl['name']);
    		 $filter->filter($files['slika']);
    		 $postTable->editPost($id.'-'.$fajl['name'], $id);
    		 
    		 $this->generisiIkonicu($id.'-'.$fajl['name'], $id);
    		 
    		 $fm = new FlashMessenger();
    		 $config = $this->getServiceLocator()->get('config');
    		 $fm->addMessage($config['messages']['post_success']);
    	         				
    		 return $this->redirect()->toRoute('application/korisnik', array(
    		     'action' =>  'index'));
        }
    	else 
    	{
    	    return $this->notFoundAction();
    	}
    	
    }
    
    public function generisiIkonicu($imageFileName)
    {
        $custom = $this->getCustom();
        $putanja = $custom->getFileUploadLocation();
        $slikaFileName = $putanja . '/' . $imageFileName;
        $ikonicaFileName = 'tn_' . $imageFileName;
        $webino = $this->getServiceLocator()->get('WebinoImageThumb');
        $slika = $webino->create($slikaFileName,$options = array());
        $dim =$slika->getCurrentDimensions();
        if($dim['width'] > 750)
        {
            $slika->resize(750, 0);
            unlink($putanja ."/" . $imageFileName);
            $slika->save($putanja . '/' . $imageFileName);
        }
        $slika->resize(0, 150);
        $slika->save($putanja . '/' . $ikonicaFileName);
    
    }
    
    
    public function prikazSlikeAction()
    {
        $custom = $this->getCustom();
        $slika = $this->params()->fromRoute('id');       
        $putanja    = $custom->getFileUploadLocation();
        $filename = $putanja ."/" .'tn_'. $slika;
        $file = file_get_contents($filename);
    
        $response = $this->getEvent()->getResponse();
        $response->setContent($file);
    
        return $response;
    }
        
    public function deletePostAction()
    {  
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id = $this->params()->fromRoute('id');
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        $komTable->delKomByPost($id);
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        
        $post = $postTable->getPostById($id);
        $putanja = $custom->getFileUploadLocation();
        unlink($putanja ."/" . $post->slika);
        unlink($putanja ."/" .'tn_'. $post->slika);
        
        $postTable->deletePost($id);
        
        return $this->redirect()->toRoute('application/korisnik', array(
            'action' =>  'index'));
    }
}