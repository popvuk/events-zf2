<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Application\Model\Kategorija;
use GoogleMaps\Geocoder;
use GoogleMaps\Request;


class AdminController extends AbstractActionController
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
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $posts = $postTable->getWaitingPosts();
        
		      

        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
        
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$posts->buffer()));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(5)
                  ->setPageRange(5);
        
        $model = $custom->getViewModel();
        $model->setVariables(array('posts'=>$paginator, 'action'=>'index'));
        return $model;
    }
    
    public function postAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id = $this->params()->fromRoute('id'); 
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $post = $postTable->getPostById($id);      
      //  $form = $this->getServiceLocator()->get('OdobrenjeForm');
        try
        {
            $map = $this->getGoogleMap($post->lokacija);
        }
        catch (\Exception $ex)
        {
            $map=null;
        }
        $model =$custom->getViewModel();
        $model->setVariables(array('mapa'=>$map,'post'=>$post));
        return $model;
    }
    
    public function confirmAction()
    {  
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id = $this->params()->fromRoute('id');
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $korime = $this->params()->fromRoute('korime');
        try 
        {
            $postTable->updatePost($id);
            $config = $this->getServiceLocator()->get('config');
            $this->sendMail($korime, $config['messages']['post_confirm']);
        }
        catch (\Exception $e)
        {
            return $this->notFoundAction();
        }
             	
           
        return $this->redirect()->toRoute(NULL , array('controller' => 'admin', 'action' =>'index'));
    }
    
    public function declineAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id = $this->params()->fromRoute('id');
        $korime = $this->params()->fromRoute('korime');
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        try
        {
            $config = $this->getServiceLocator()->get('config');
            $this->sendMail($korime, $config['messages']['post_error']);
            
            $post = $postTable->getPostById($id);
            $putanja = $custom->getFileUploadLocation();
            unlink($putanja ."/" . $post->slika);
            unlink($putanja ."/" .'tn_'. $post->slika);
            
            $postTable->deletePost($id);
        }
        catch (\Exception $ex)
        {
            return $this->notFoundAction();
        }
        return $this->redirect()->toRoute(NULL , array('controller' => 'admin', 'action' =>'index'));
    }
    
    protected function sendMail($korime, $body)
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $korTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
        $korisnik = $korTable->getKorisnikByKorime($korime);
    
        $emailTable = $di->get('Application\Model\EmailTable', array('table'=>'email'));
        $email = $emailTable->fetch();
    
        $message = new Message();
        $message->addTo($korisnik->email)
                ->addFrom($email->username)
                ->setSubject("Postavljanje posta na EventNis")
                ->setBody($body);
        $transport = new Smtp();
        $options   = new SmtpOptions(array(
            'name'              => $email->server_name,
            'host'              => $email->host,
            'port'              => $email->port,
            'connection_class'  => 'login',
            'connection_config' => array(
                'username' => $email->username,
                'password' => $email->password,
                'ssl'      =>$email->ssl_tls,
            ),
        ));
         
        $transport->setOptions($options);
        $transport->send($message);        	
    }
    
    public function findAction()
    {
        $custom = $this->getCustom();
        $form = $this->getServiceLocator()->get('FindForm');
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form, 'result'=>null));
        
        return $model;
    }
    
    public function findKorAction()
    {  
        $custom = $this->getCustom();
        $di=$custom->confDi();
        if (!$this->request->isPost())
    	{
    		return $this->notFoundAction();
    	}
    	$post = $this->request->getPost();
    	$form = $this->getServiceLocator()->get('FindForm');
    	$form->setData($post);
    	
    	if (!$form->isValid())
    	{
    	    $model=$custom->getViewModel();
    	    $model->setVariables(array('error' => true,'form' => $form,));
    	    $model->setTemplate('application/admin/find');
    	    return $model;
    	}
    	
    	$korTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
    	$korisnik = $korTable->getKorisnikByKorime($this->request->getPost('korime'));
    	$model = $custom->getViewModel();
    	$model->setVariables(array('form' => $form,'result'=>$korisnik));
    	$model->setTemplate('application/admin/find');
    	return $model;
    }
    
    public function deleteKorAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id_kor = $this->params()->fromRoute('id');
        
        $korTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
        $korisnik = $korTable->getKorisnik($id_kor);
        
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        $komTable->delKomByKor($korisnik->korime);
        
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $postovi = $postTable->getPostsById($id_kor);
        
        foreach ($postovi as $post)
        {
            $this->deletePost($post->id_post);
        }
        
        $korTable->deleteKor($id_kor);
        
        return $this->redirect()->toRoute(NULL , array('controller' => 'admin', 'action' =>  'index',
        ));
    }
    
    public function deletePost($id)
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
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
    
    public function kategorijeAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $form = $this->getServiceLocator()->get('KategorijaForm');
        $katTable = $di->get('Application\Model\KategorijaTable', array('table'=>'kategorija'));
        $kat = $katTable->fetchAll();
        
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form, 'kats'=>$kat));
        return $model;
    }
    
    public function addKatAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        if (!$this->request->isPost())
        {
            return $this->notFoundAction();
        }

        $katTable = $di->get('Application\Model\KategorijaTable', array('table'=>'kategorija'));
        $kat = $katTable->fetchAll();
        
        $post = $this->request->getPost();
    	$form = $this->getServiceLocator()->get('KategorijaForm');
    	$form->setData($post);
    	
    	$model=$custom->getViewModel();
    	
    	if (!$form->isValid())
    	{  	    
    	    $model->setVariables(array('error' => true,'form' => $form,'kats'=>$kat));
    	    $model->setTemplate('application/admin/kategorije');
    	    return $model;
    	}
    	
    	$kat = new Kategorija();
    	$kat->exchangeArray($form->getData());
    	
    	$katTable->createKat($kat);
    	$kat = $katTable->fetchAll();
    	$model->setVariables(array('form' => $form,'kats'=>$kat));
    	$model->setTemplate('application/admin/kategorije');
    	return $model;
    }
    
    public function delKatAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id = $this->params()->fromRoute('id');
        
        $katTable = $di->get('Application\Model\KategorijaTable', array('table'=>'kategorija'));
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        
        $posts = $postTable->getDelPosts($id);
        
        foreach ($posts as $post)
        {
            $this->deletePost($post->id_post);
        }
        
        $katTable->deleteKat($id);
         
        $form = $this->getServiceLocator()->get('KategorijaForm');
        $kat = $katTable->fetchAll();
        $model=$custom->getViewModel();
        $model->setVariables(array('form' => $form,'kats'=>$kat));
        $model->setTemplate('application/admin/kategorije');
        return $model;
    }
    
    protected function getGoogleMap($address)
    {
        $request = new Request();
        $request->setAddress($address);
    
        $proxy = new Geocoder();
        $response = $proxy->geocode($request);
        $resultset=$response->getResults();
        $result = $resultset[0];
        $geometry = $result->getGeometry();
        $location = $geometry->getLocation();
         
        $config = array(
            'sensor' => 'true',
            'div_id' => 'map',
            'div_class' => 'grid_6',
            'zoom' => 17,
            'width' => "100%",
            'height' => "300px",
            'lat' => $location->getLat(),
            'lon' => $location->getLng(),
            'animation' => 'none',
        );
    
        $map = $this->getServiceLocator()->get('GMaps\Service\GoogleMap');
        $map->initialize($config);
        $html = $map->generate();
    
        return $html;
    }
}