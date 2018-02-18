<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use GoogleMaps\Request;
use GoogleMaps\Geocoder;


class PostController extends AbstractActionController
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
        $id = $this->params()->fromRoute('id');
        $di=$custom->confDi();
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        
        $post = $postTable->getPostById($id);
        
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        $kom = $komTable->getKomByPost($id);
        
        $form = $this->getServiceLocator()->get('KomentarForm');
        try 
        {
            $map = $this->getGoogleMap($post->lokacija);
        }
        catch (\Exception $ex)
        {
            $map=null;
        }
        
        $auth = $this->getServiceLocator()->get('AuthService');
        $storage = $auth->getStorage()->read();
        $korime = $storage['korisnik'];
                
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form,'mapa'=>$map,'korisnik'=>$korime,'post'=>$post,'komentari'=>$kom,
		          'id'=>$id,'flashMessages' => $this->flashMessenger()->getMessages()));
        
        return $model;
    }
    
    public function prikazSlikeFullAction()
    {
        $custom = $this->getCustom();
        $slika = $this->params()->fromRoute('id');
        $putanja    = $custom->getFileUploadLocation();
        $filename = $putanja ."/" . $slika;
        $file = file_get_contents($filename);
    
        $response = $this->getEvent()->getResponse();
        $response->setContent($file);
    
        return $response;
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
    
    public function delKomAction()
    {  
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id_kom = $this->params()->fromRoute('id');
        $komTable = $di->get('Application\Model\KomentarTable',array('table'=>'komentar'));
        $komentar = $komTable->getKomById($id_kom);
        $id = $komentar->id_post;
        $komTable->delKomentar($id_kom);
        
        return $this->redirect()->toRoute('application/post',
            array('action' =>'index','id'=> $id));
    }
    
   
    
}