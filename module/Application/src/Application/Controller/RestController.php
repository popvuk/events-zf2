<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Korisnik;
use Application\Model\Komentar;
use Application\Model\Post;


class RestController extends AbstractActionController
{
    protected $authservice;
    protected $custom;
    
    public function getCustom()
    {
        if($this->custom == null)
        {
            $this->custom = $this->Custom();
        }
        
        return $this->custom;
    }
    
    protected function getAuthService()
    {
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }
    
    public function indexAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
        $post = $postTable->getPostsByKorime(null);
        
        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
        
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$post->buffer()));
        $paginator->setCurrentPageNumber($page);
        $paginator ->setItemCountPerPage(4);
        
        $pages=$paginator->count();
 
        $str['brstrana'] = $pages;
        $niz=array();
        $niz[] = $str;
        if($page > $pages)
           return $this->response->setContent(json_encode($niz));
        
        foreach ($paginator as $pag)
        {
            $niz[]=$pag;
        }
            
        return $this->response->setContent(json_encode($niz));
    }
    
    public function imageAction()
    {
        $slika = $this->params()->fromRoute('id');     
        $config = $this->getServiceLocator()->get('config');
        $putanja = $config['module_config']['upload_location'];
        
        $filename = $putanja."/".$slika; 
       // $filename = str_replace(" ", "%20", $filename);		
        $file = file_get_contents($filename);
        
        return $this->response->setContent($file);
       
    }
    
    public function komentariAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        $id =  $this->params()->fromRoute('id');
        $kom = $komTable->getKomByPost($id);
        $niz=array();
        
        foreach ($kom as $k)
        {
            $niz[]=$k;
        }
        return $this->response->setContent(json_encode($niz));
    }
    
    public function kategorijeAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
          
        $page=1;
        if($this->params()->fromRoute('id'))
            $kategorija = $this->params()->fromRoute('id');
        if($this->params()->fromRoute('page'))
            $page = $this->params()->fromRoute('page');
        
        $post = $postTable->getPostsByKat($kategorija);
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$post->buffer()));
        $paginator->setCurrentPageNumber($page);
        $paginator ->setItemCountPerPage(4);
    
        $pages=$paginator->count();
 
        $str['brstrana'] = $pages;
        $niz=array();
        $niz[] = $str;
    
        if($page > $pages)
            return $this->response->setContent(json_encode($niz));
    
        foreach ($paginator as $pag)
        {
            $niz[]=$pag;
        }
         
        return $this->response->setContent(json_encode($niz));
    }
    
    public function registracijaAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $obj = file_get_contents('php://input');
        $json = json_decode($obj);    

        $data = array();
        $data['korime']=$json->{'korime'};
        $data['sifra'] = $json->{'sifra'};
        $data['ime'] = $json->{'ime'};
        $data['prezime']=$json->{'prezime'};
        $data['email'] = $json->{'email'};
      
        $korisnik = new Korisnik();
        $korisnik->exchangeArray($data);
        
        $config = $this->getServiceLocator()->get('config');
        try
        {
            $korisnikTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
            $korisnikTable->createKorisnik($korisnik);
        }
        catch (\Exception $ex)
        {
            return $this->response->setContent($config['messages']['register_error']);
        }
        
       return $this->response->setContent($config['messages']['register_success']);
    }
    
    public function getMailAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $mailTable = $di->get('Application\Model\EmailTable', array('table'=>'email'));
        $mail = $mailTable->fetch();
        
        return $this->response->setContent(json_encode($mail));
    }
    
    public function loginAction()
    {
        $obj = file_get_contents('php://input');
        $json = json_decode($obj);
        $this->getAuthService()->clearIdentity();//uklanja identitet iz session storega
        //check authentication...
        $this->getAuthService()->getAdapter()
                               ->setIdentity($json->{'korime'})
                               ->setCredential($json->{'sifra'});
        $result = $this->getAuthService()->authenticate();
        if ($result->isValid())
        {
            return $this->response->setContent("true");
        }
        else 
        {
            return $this->response->setContent("false");
        }
    }
    
    public function setCommentAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $config = $this->getServiceLocator()->get('config');
        try 
        {
            $obj = file_get_contents('php://input');
            $json = json_decode($obj);
			$date = new \DateTime();
		    $zone = new \DateTimeZone('Europe/Belgrade');
		    $date->setTimezone($zone);
            $format = $date->format('Y-m-d H:i:s');
            $data = array();
            $data['id_post'] = $json->{'id_post'};
            $data['korime'] = $json->{'korime'};
            $data['vreme'] = $format;
            $data['komentar'] = $json->{'komentar'};
            
            $komentar = new Komentar();
            $komentar->exchangeArray($data);
            
            $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
            $komTable->createKomentar($komentar);
            
            return $this->response->setContent($config['messages']['komentar_success']);
        }
        catch(\Exception $ex)
        {
            return $this->response->setContent($config['messages']['komentar_failed']);
        }
        
    }
    
    public function korisnikAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
          
        $page=1;
        if($this->params()->fromRoute('id'))
            $korime = $this->params()->fromRoute('id');
        if($this->params()->fromRoute('page'))
            $page = $this->params()->fromRoute('page');
        
        $post = $postTable->getPostsByKorime($korime);
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$post->buffer()));
        $paginator->setCurrentPageNumber($page);
        $paginator ->setItemCountPerPage(4);
    
        $pages=$paginator->count();
 
        $str['brstrana'] = $pages;
        $niz=array();
        $niz[] = $str;
   
        if($page > $pages)
            return $this->response->setContent(json_encode($niz));
    
        foreach ($paginator as $pag)
        {
            $niz[]=$pag;
        }
         
        return $this->response->setContent(json_encode($niz));
    }
    
    public function postAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $config = $this->getServiceLocator()->get('config');
		
		$data = array_merge_recursive(
         			$this->getRequest()->getPost()->toArray(),
         			$this->getRequest()->getFiles()->toArray()
    	     );
         	
         	$form = $this->getServiceLocator()->get('PostForm');
    		$form->setData($data);
    		
     		if (!$form->isValid()) 
    	    {
    	    	return $this->response->setContent($config['messages']['post_failed']); 	
    		 }   		
			
        try 
        {      
            $putanja = $config['module_config']['upload_location'];
            
            $fajl = $this->params()->fromFiles('slika');
            $files   = $this->getRequest()->getFiles();
             
            $post = new Post();
            $exchange_data = array();
			
		 
            $exchange_data['slika'] = $fajl['name'];
            $korisnikTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
            $korime = $this->getRequest()->getPost('korime');
            $korisnik = $korisnikTable->getKorisnikByKorime($korime);
            $exchange_data['id_korisnik'] = $korisnik->id;
            $exchange_data['id_kat'] = $this->getRequest()->getPost('id_kat');
            $exchange_data['naslov'] = $this->getRequest()->getPost('naslov');
		
            $data = new \DateTime(date('m.d.y'));
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
			
			$vreme = $this->getRequest()->getPost('vreme');
			//if(!preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $vreme))
			//{
				//return $this->response->setContent($config['messages']['post_failed']);
			//}
		
            $exchange_data['vreme'] = $vreme;
            $exchange_data['lokacija'] = $this->getRequest()->getPost('lokacija');
            $exchange_data['tekst'] = $this->getRequest()->getPost('tekst');
            
			$post->exchangeArray($exchange_data);
            
            $postTable = $di->get('Application\Model\PostTable', array('table'=>'post'));
            $id = $postTable->createPost($post);
            
            $filter = new  \Zend\Filter\File\RenameUpload($putanja.'/'.$id.'-'.$fajl['name']);
            $filter->filter($files['slika']);
            $postTable->editPost($id.'-'.$fajl['name'], $id);
            
            $this->generisiIkonicu($id.'-'.$fajl['name'], $id);
            
            return $this->response->setContent($config['messages']['post_success']);
            
        }
        catch(\Exception $e)
        {
           return $this->response->setContent($config['messages']['post_failed']);
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
		
        $config = $this->getServiceLocator()->get('config');
        return $this->response->setContent($config['messages']['post_delete']);
    }
    
    public function deleteKomentarAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $id_kom = $this->params()->fromRoute('id');
        $komTable = $di->get('Application\Model\KomentarTable', array('table'=>'komentar'));
        $komTable->delKomentar($id_kom);
        $config = $this->getServiceLocator()->get('config');
    
        return $this->response->setContent($config['messages']['komentar_delete']);
    }
    
    public function getKorisnikAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $korime = $this->params()->fromRoute('id');
        
        $korisnikTable = $di->get('Application\Model\KorisnikTable', array('table'=>'korisnik'));
        $korisnik = $korisnikTable->getKorisnikByKorime($korime);
        
        return $this->response->setContent($korisnik->id);
    }

	public function getKategorijeAction()
	{
		$custom = $this->getCustom();
        $di=$custom->confDi();
        $katTable = $di->get('Application\Model\KategorijaTable', array('table'=>'kategorija'));
		$kategorije=$katTable->fetchAll();
		
		$niz=array();
        foreach ($kategorije as $kat)
        {
            $niz[]= array('item'=>$kat->naziv_kat, 'value'=>$kat->id_kat);
        }
		return $this->response->setContent(json_encode($niz));
	}
}