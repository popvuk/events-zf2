<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Application\Model\KorisnikTable;
use Zend\Db\ResultSet\ResultSet;
use Application\Model\Korisnik;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\EmailTable;
use Application\Model\Email;
use Application\Model\PostTable;
use Application\Model\Post;
use Application\Model\KategorijaTable;
use Application\Model\Kategorija;
use Application\Model\KomentarTable;
use Application\Model\Komentar;
use Application\Model\DozvolaTable;
use Application\Model\Dozvola;
use Application\Model\ResursTable;
use Application\Model\Resurs;
use Zend\Permissions\Acl\Acl;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Application\Model\RolaTable;
use Application\Model\Rola;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $this->initAcl($e);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkAcl')); //Acl check
		$eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setTranslator'));
		
        $moduleRouteListener->attach($eventManager);
    }
    
	public function setTranslator(MvcEvent $e)
    {
         $translator = $e->getApplication()->getServiceManager()->get('translator');
         $translator->addTranslationFile('phpArray', './vendor/zendframework/zendframework/resources/languages/sr/Zend_Validate.php');
         AbstractValidator::setDefaultTranslator($translator);        
    }
	
    public function initAcl(MvcEvent $e)
    {
    
        $acl = new Acl();
    
        $rolaTable = $e->getApplication()->getServiceManager()->get('RolaTable');
        $role = $rolaTable->fetchAll();      
        $resursTable = $e->getApplication()->getServiceManager()->get('ResursTable');
        $resursi = $resursTable->fetchAll();
        $dozvolaTable = $e->getApplication()->getServiceManager()->get('DozvolaTable');
         
        foreach ($resursi as $resurs)
        {
            $acl->addResource($resurs->kontroler);//dodajemo resurse
        }
    
        foreach ($role as $rola)
        {
            $acl->addRole($rola->naziv_rola);//dodajemo role
    
            $dozvole = $dozvolaTable->getDozvole((int)$rola->id_rola);//vraca id-jeve
    
            foreach ($dozvole as $dozvola)
            {
                $resurs = $resursTable->getResurs((int)$dozvola->id_resurs);
                $acl->allow($rola->naziv_rola, $resurs->kontroler);//dodajemo dozvole
            }
        }
        //setting to view
        $e->getViewModel()->acl = $acl;
    
    }
    
    public function checkAcl(MvcEvent $e)
    {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
    
        $storage = $e->getApplication()->getServiceManager()->get('AuthService')->getStorage()->read();
        $role=$storage['rola'];
         
        if ($role != null)
        {
            $userRole = $role;
        }
        else
        {
            $userRole = 'gost';
        }
                
        if (!$e->getViewModel()->acl->hasResource($controller) || !$e->getViewModel()->acl->isAllowed($userRole, $controller))
        {
            $fm = new FlashMessenger();
            
            if($e->getApplication()->getServiceManager()->get('AuthService')->hasIdentity())//ako je logovan
            {
               
                $fm->addMessage('Pristup vam nije dozvoljen');
                $router = $e->getRouter();
                if($userRole == 'korisnik')
                {
                    $url = $router->assemble(array(), array('name' => 'application/korisnik'));
                }
                elseif ($userRole == 'administrator')
                {
                    $url = $router->assemble(array(), array('name' => 'application/admin'));
                }
                 
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                                
                return $response;
            }
            
            $fm->addMessage('Pristup  nije dozvoljen');
            $router = $e->getRouter();//ako je gost
            $url = $router->assemble(array(), array('name' => 'application/index'));
    
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
    
            return $response;
        }
    
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'abstract_factories' => array(),
            'aliases' => array(),
            'factories' => array(
                // SERVICES
                'AuthService' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'korisnik', 'korime', 'sifra', 'MD5(?)');
        
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                // DB
                'KorisnikTable' =>  function($sm) {
                    $tableGateway = $sm->get('KorisnikTableGateway');
                    $table = new KorisnikTable($tableGateway);
                    return $table;
                },
                'KorisnikTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Korisnik());
                    return new TableGateway('korisnik', $dbAdapter, null, $resultSetPrototype);
                },
                'EmailTable' =>  function($sm) {
                    $tableGateway = $sm->get('EmailTableGateway');
                    $table = new EmailTable($tableGateway);
                    return $table;
                },
                'EmailTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Email());
                    return new TableGateway('email', $dbAdapter, null, $resultSetPrototype);
                },
                'PostTable' =>  function($sm) {
                    $tableGateway = $sm->get('PostTableGateway');
                    $table = new PostTable($tableGateway);
                    return $table;
                },
                'PostTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Post());
                    return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
                },
                'KategorijaTable' =>  function($sm) {
                    $tableGateway = $sm->get('KategorijaTableGateway');
                    $table = new KategorijaTable($tableGateway);
                    return $table;
                },
                'KategorijaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Kategorija());
                    return new TableGateway('kategorija', $dbAdapter, null, $resultSetPrototype);
                },
                'KomentarTable' =>  function($sm) {
                    $tableGateway = $sm->get('KomentarTableGateway');
                    $table = new KomentarTable($tableGateway);
                    return $table;
                },
                'KomentarTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Komentar());
                    return new TableGateway('komentar', $dbAdapter, null, $resultSetPrototype);
                },
                'DozvolaTable' =>  function($sm) {
                    $tableGateway = $sm->get('DozvolaTableGateway');
                    $table = new DozvolaTable($tableGateway);
                    return $table;
                },
                'DozvolaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Dozvola());
                    return new TableGateway('dozvola', $dbAdapter, null, $resultSetPrototype);
                },
                'ResursTable' =>  function($sm) {
                    $tableGateway = $sm->get('ResursTableGateway');
                    $table = new ResursTable($tableGateway);
                    return $table;
                },
                'ResursTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Resurs());
                    return new TableGateway('resurs', $dbAdapter, null, $resultSetPrototype);
                },
                'RolaTable' =>  function($sm) {
                    $tableGateway = $sm->get('RolaTableGateway');
                    $table = new RolaTable($tableGateway);
                    return $table;
                },
                'RolaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Rola());
                    return new TableGateway('rola', $dbAdapter, null, $resultSetPrototype);
                },
                // FORMS
                'LoginForm' => function ($sm) {
                    $form = new \Application\Form\LoginForm();
                    $form->setInputFilter($sm->get('LoginFilter'));
                    return $form;
                },
                'RegisterForm' => function ($sm) {
                    $form = new \Application\Form\RegisterForm();
                    $form->setInputFilter($sm->get('RegisterFilter'));
                    return $form;
                },
                'PostForm' => function ($sm) {
                    $form = new \Application\Form\PostForm();
                    $form->setInputFilter($sm->get('PostFilter'));
                    return $form;
                },
                'KomentarForm' => function ($sm) {
                    $form = new \Application\Form\KomentarForm();
                    $form->setInputFilter($sm->get('KomentarFilter'));
                    return $form;
                },
                'SelectForm' => function ($sm) {
                    $form = new \Application\Form\SelectForm();
                    return $form;
                },
                'FindForm' => function ($sm) {
                    $form = new \Application\Form\FindForm();
                    $form->setInputFilter($sm->get('FindFilter'));
                    return $form;
                },
                'KontaktForm' => function ($sm) {
                    $form = new \Application\Form\KontaktForm();
                    $form->setInputFilter($sm->get('KontaktFilter'));
                    return $form;
                },
                'KategorijaForm' => function ($sm) {
                    $form = new \Application\Form\KategorijaForm();
                    $form->setInputFilter($sm->get('KategorijaFilter'));
                    return $form;
                },
                // FILTERS
                'LoginFilter' => function ($sm) {
                    return new \Application\Form\LoginFilter();
                },
                'RegisterFilter' => function ($sm) {
                    return new \Application\Form\RegisterFilter();
                },
                'PostFilter' => function ($sm) {
                    return new \Application\Form\PostFilter();
                },
                'KomentarFilter' => function ($sm) {
                    return new \Application\Form\KomentarFilter();
                },
                'FindFilter' => function ($sm) {
                    return new \Application\Form\FindFilter();
                },
                'KontaktFilter' => function ($sm) {
                    return new \Application\Form\KontaktFilter();
                },
                'KategorijaFilter' => function ($sm) {
                    return new \Application\Form\KategorijaFilter();
                },
             ),
                'invokables' => array(),
                'services' => array(),
                'shared' => array(),
        );
    }
}
