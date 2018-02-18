<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Facebook\Facebook;


class FacebookController extends AbstractActionController
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
        $fb = $this->getFB();
        $id = $this->params()->fromRoute('id');
        $response = $fb->get('/'.$id.'/photos?limit=5');
        $graphEdge = $response->getGraphEdge();

        $next = $graphEdge->getNextCursor();
        $previous = $graphEdge->getPreviousCursor();
              
        $objekat = $fb->get('/'.$id.'?fields=from');
        $node = $objekat->getGraphNode();
        
        $model = $custom->getViewModel();
        $model->setVariables(array('feeds'=>$graphEdge, 'naslov'=>$node['from']['name'], 'next'=>$next, 'previous'=>$previous, 'id'=>$node['id']));
        return $model;
    }
    
    public function pagingAction()
    {
        $custom = $this->getCustom();
        $fb = $this->getFB();
        $direction = $this->params()->fromRoute('direction');              
        $id = $this->params()->fromRoute('id');
        $tip = $this->params()->fromRoute('tip');
        
        if($tip == 'next')
        {
            $response = $fb->get('/'.$id.'/photos?pretty=0&limit=5&after='.$direction);
        }
        else if($tip == 'prev')
        {
            $response = $fb->get('/'.$id.'/photos?pretty=0&limit=5&before='.$direction);
        }       
        
        $graphEdge = $response->getGraphEdge();
        
        if($graphEdge->asArray()==null)
        {
            $response = $fb->get('/'.$id.'/photos?limit=5');
            $graphEdge = $response->getGraphEdge();
        }
        
        $next = $graphEdge->getNextCursor();
        $previous = $graphEdge->getPreviousCursor();
        
        $objekat = $fb->get('/'.$id.'?fields=from');
        $node = $objekat->getGraphNode();
               
        $model = $custom->getViewModel();
        $model->setVariables(array('feeds'=>$graphEdge, 'naslov'=>$node['from']['name'], 'next'=>$next, 'previous'=>$previous, 'id'=>$node['id']));
        $model->setTemplate('application/facebook/index');
        return $model;
    }
    
  
    public function prikazAction()
    {
         $fb = $this->getFB();
         $id = $this->params()->fromRoute('id');
         $file = $this->params()->fromRoute('direction');
         
         if($file == 'photo')
         {
             $media = $fb->get('/'.$id.'?fields=source');
         }
         if($file == 'video')
         {
             $media = $fb->get('/'.$id.'?fields=source');
         }
          
         $graphNode = $media->getGraphNode();
         
         $filename=$graphNode['source'];
           
         $file = file_get_contents($filename);
         
         $response = $this->getEvent()->getResponse();
         $response->setContent($file);
         
         return $response;   
    }
    
    public function videoAction()
    {
        $custom = $this->getCustom();
        $fb = $this->getFB();
        $id = $this->params()->fromRoute('id');
       
        $graphEdge = $fb->get('/'.$id.'/videos?limit=5');
        $videos = $graphEdge->getGraphEdge();
        
        $next = $videos->getNextCursor();
        $previous = $videos->getPreviousCursor();
        
        $graphNode = $fb->get($id);
        $objekat = $graphNode->getGraphNode();
         
        $model = $custom->getViewModel();
        $model->setVariables(array('feeds'=>$videos,'naslov'=>$objekat['name'], 'next'=>$next, 'previous'=>$previous, 'id'=>$objekat['id']));
        return $model;
    }
    
    public function pagingVideoAction()
    {
        $custom = $this->getCustom();
        $fb = $this->getFB();
        $direction = $this->params()->fromRoute('direction');
        $id = $this->params()->fromRoute('id');
        $tip = $this->params()->fromRoute('tip');
    
        if($tip == 'next')
        {
            $response = $fb->get('/'.$id.'/videos?pretty=0&limit=5&after='.$direction);
        }
        else if($tip == 'prev')
        {
            $response = $fb->get('/'.$id.'/videos?pretty=0&limit=5&before='.$direction);
        }
    
        $graphEdge = $response->getGraphEdge();
    
        if($graphEdge->asArray()==null)
        {
            $response = $fb->get('/'.$id.'/videos?limit=5');
            $graphEdge = $response->getGraphEdge();
        }
    
        $next = $graphEdge->getNextCursor();
        $previous = $graphEdge->getPreviousCursor();
    
        $objekat = $fb->get($id);
        $node = $objekat->getGraphNode();
         
        $model = $custom->getViewModel();
        $model->setVariables(array('feeds'=>$graphEdge, 'naslov'=>$node['name'], 'next'=>$next, 'previous'=>$previous, 'id'=>$node['id']));
        $model->setTemplate('application/facebook/video');
        return $model;
    }
    
    
    protected function getFB()
    { 
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $config = $this->getServiceLocator()->get('config');

        $faceconf = array(
            'app_id' => $config['facebook_config']['appid'],
            'app_secret' => $config['facebook_config']['appsecret'],
            'default_graph_version' => 'v2.4',
        );
        
        $fb = $di->get('Facebook\Facebook', array('config'=>$faceconf));

        $fb->setDefaultAccessToken($config['facebook_config']['accesstoken']);
        return $fb;
    }
}