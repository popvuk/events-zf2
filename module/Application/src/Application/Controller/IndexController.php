<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class IndexController extends AbstractActionController
{
    protected $storage;
    protected $authservice;
    
    protected $custom;
    
   
    protected function getAuthService()
    {
        if (! $this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

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
        $form = $this->getServiceLocator()->get('LoginForm');

        $postTable = $di ->get('Application\Model\PostTable',array('table'=>'post'));
        $post = $postTable->getPostsByKorime(null);
        
        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
               
        $di = $custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$post->buffer()));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(5)
                  ->setPageRange(5);
        
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form, 'posts'=>$paginator, 'flashMessages' => $this->flashMessenger()->getMessages(), 'action'=>'index'));
        return $model;
    }
    
    public function loginAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        if (!$this->request->isPost())
    	{
    		return $this->notFoundAction();
    	}
        
        $postTable =  $di ->get('Application\Model\PostTable',array('table'=>'post'));
        $posts = $postTable->getPostsByKorime(null);
         
        $post = $this->request->getPost();
		$form = $this->getServiceLocator()->get('LoginForm');
        $form->setData($post);
        
        if (!$form->isValid()) 
		{
            $model =$custom->getViewModel();
            $model->setVariables(array('form'  => $form,'posts'=>$posts,));
            $model->setTemplate('application/index/index');
            return $model;
        } 
		else 
		{
			$this->getAuthService()->clearIdentity();//uklanja identitet iz session storega
			$this->getAuthService()->getStorage()->clear();//za slucaj da nije izvresn logout
			//check authentication...
			$this->getAuthService()->getAdapter()
								   ->setIdentity($this->request->getPost('korime'))
								   ->setCredential($this->request->getPost('sifra'));
            $result = $this->getAuthService()->authenticate();
            
            if ($result->isValid()) //prolazi validaciju
            {
            	$korTable = $di ->get('Application\Model\KorisnikTable',array('table'=>'korisnik'));
            	$kor=$korTable->getKorisnikByKorime($this->request->getPost('korime'));
            	if($kor->naziv_rola == 'korisnik')
            	{
            	    $korisnik=$kor->korime;
            	    $rola=$kor->naziv_rola;
            	    $this->getAuthService()->getStorage()->write(array('korisnik'=>$korisnik, 'rola'=>$rola));
            	    return $this->redirect()->toRoute('application/korisnik', array(
            	        'action' =>  'index'
            	    ));
            	}
            	elseif ($kor->naziv_rola == 'administrator')
            	{
            		$korisnik=$kor->korime;
            		$rola=$kor->naziv_rola;
            		$this->getAuthService()->getStorage()->write(array('korisnik'=>$korisnik, 'rola'=>$rola));
            		return $this->redirect()->toRoute('application/admin', array(
            				'action' =>  'index'
            		));
            	}
            	else
            	{
            	    $fm = new FlashMessenger();
            	    $fm->addMessage('Netačno korisničko ime i/ili lozinka');
            		return $this->forward()->dispatch('Application\Controller\index', array('action' => 'index'));
            	}							
            } 
            else
            {
                $fm = new FlashMessenger();
                $fm->addMessage('Netačno korisničko ime i/ili lozinka');
				return $this->forward()->dispatch('Application\Controller\index', array('action' => 'index'));			
			}
		}     
    }
    
    public function logoutAction()
    {
        $this->getAuthService()->clearIdentity();
        $this->getAuthService()->getStorage()->clear();
        
        return $this->redirect()->toRoute('application/index', array(
        				'action' =>  'index'
        ));
    }

    public function sortAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $kat = $this->getRequest()->getPost('kategorije');
        $postTable =  $di ->get('Application\Model\PostTable',array('table'=>'post'));
        $posts = $postTable->getPostsByKat($kat);
        
        $form = $this->getServiceLocator()->get('LoginForm');
 
        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
        
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$posts->buffer()));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(5)
                  ->setPageRange(5);
        
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form,'posts'=>$paginator, 'action'=>'sort'));
        $model->setTemplate('application/index/index');
        return $model;
    }
    
    public function contactAction()
    {
        $custom = $this->getCustom();
        $form = $this->getServiceLocator()->get('KontaktForm');
        $model = $custom->getViewModel();
        $model->setVariables(array('contact'=>$form));
        return $model;
    }
    
    public function sendMssgAction()
    {
        if (!$this->request->isPost())
    	{
    		return $this->notFoundAction();
    	}
        
        $post = $this->request->getPost();        
        $form = $this->getServiceLocator()->get('KontaktForm');
        $form->setData($post);
         
        if (!$form->isValid())
        {
            $custom = $this->getCustom();
            $model = $custom->getViewModel();
            $model->setVariables(array('contact'=>$form, 'erorr'=>true));
            $model->setTemplate('application/index/contact');
            return $model;
        }
        
        try 
        {
          $this->sendMail($form->getData());  
        }
        catch (\Exception $ex)
        {
    		return $this->notFoundAction();  	
        }
        
       $viewmodel= $this->contactAction();
       $viewmodel->setTemplate('application/index/contact');
       return $viewmodel->setVariable('mssg', true);
    }
    
    protected function sendMail(array $data)
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $mailTable =  $di ->get('Application\Model\EmailTable',array('table'=>'email'));
        $mail = $mailTable->fetch();
    
        $message = new Message();
        $message->addTo($mail->username)
                ->addFrom($data['email'])
                ->addReplyTo($data['email'], $data['ime'])
                ->setSubject('Event Nis :'.''.$data['ime'])
                ->setBody($data['poruka']);
         
        // Setup SMTP transport using LOGIN authentication
        $transport = new SmtpTransport();
        $options   = new SmtpOptions(array(
            'name'              => $mail->server_name,
            'host'              => $mail->host,
            'port'              => $mail->port,
            'connection_class'  => 'login',
            'connection_config' => array(
                'username' => $mail->username,
                'password' => $mail->password,
                'ssl'      =>$mail->ssl_tls,
            ),
        ));
        $transport->setOptions($options);
        $transport->send($message);
    }
    
    public function showAction()
    {
        $custom = $this->getCustom();
        $di=$custom->confDi();
        $korime = $this->params()->fromRoute('korime');
        $postTable =  $di ->get('Application\Model\PostTable',array('table'=>'post'));;
        $posts = $postTable->getPostsByKorime($korime);
        
        $page=1;
        if($this->params()->fromRoute('id'))
            $page = $this->params()->fromRoute('id');
        
   
        $di=$custom->confDiPaging();
        $paginator = $di->get('Zend\Paginator\Paginator', array('iterator'=>$posts->buffer()));
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage(5)
                  ->setPageRange(5);
        
        $form = $this->getServiceLocator()->get('LoginForm');
        $model = $custom->getViewModel();
        $model->setVariables(array('form'=>$form,'posts'=>$paginator, 'action'=>'show'));
        $model->setTemplate('application/index/index');
        return $model;
    }
    
    public function galleryAction()
    {
        $custom = $this->getCustom();
        $model = $custom->getViewModel();  
        return $model;
    }
}
