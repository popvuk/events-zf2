<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'index' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/index[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',

                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
					'show' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/show[/:action[/:korime[/:id]]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'korisnik' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/korisnik[/:action[/:id[/:korime]]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Korisnik',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'post' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/post[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Post',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'komentar' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/komentar[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Komentar',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'admin' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/admin[/:action[/:id[/:korime]]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Admin',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'facebook' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/facebook[/:action[/:id[/:direction[/:tip]]]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Facebook',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'rest' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/rest[/:action[/:id[/:page]]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Rest',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/register[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Register',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Register' => 'Application\Controller\RegisterController',
            'Application\Controller\Korisnik' => 'Application\Controller\KorisnikController',
            'Application\Controller\Post' => 'Application\Controller\PostController',
            'Application\Controller\Komentar' => 'Application\Controller\KomentarController',
            'Application\Controller\Admin' => 'Application\Controller\AdminController',
            'Application\Controller\Facebook' => 'Application\Controller\FacebookController',
            'Application\Controller\Pagination' => 'Application\Controller\PaginationController',
            'Application\Controller\Rest' => 'Application\Controller\RestController',
        ),
    ),
    
    'controller_plugins' => array(
        'invokables' => array(
            'Custom' => 'Application\Controller\Plugin\Custom',
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'paginator-slide' => __DIR__ . '/../view/layout/slidePagination.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    
    'module_config' => array(
        'upload_location'           => __DIR__ . '/../data/slike',
    ),
    
    'facebook_config' => array(
        'accesstoken' => 'EAAOR6XZB2y0YBAHLylgzbyDjfHwliZAmkWeTgOy8JLi4Uv0W4sZBGP00GqpaYMqfxDBK3eHzsNe7KkXz5iTBZCBkN37th6ABZB3vZBP3tTMNIchugDBGmasFZBZABYQ3A3Vy2oiYil1ZBMZCmxorVLBiX7ZA6zNaqT8LZCoZD',
        'appid' => '1004856986225478',
        'appsecret' => '67b373f00670190fc718d611dfc85d8f'
    ),
    
    'di_tables' => array(
        'instance' => array(
            'Zend\Db\TableGateway\TableGateway' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                    'table' =>null
                ),
            ),
            'Zend\Db\Adapter\Adapter' => array(
                'parameters' => array(
                    'driver' => 'Zend\Db\Adapter\Driver\Pdo\Pdo',
                ),
            ),
            'Zend\Db\Adapter\Driver\Pdo\Pdo' => array(
                'parameters' => array(
                    'connection' => 'Zend\Db\Adapter\Driver\Pdo\Connection',
                ),
            ),
            'Zend\Db\Adapter\Driver\Pdo\Connection' => array(
                'parameters' => array(
                    'connectionParameters' => array(
                        'dsn' => 'mysql:dbname=eventnis;host=localhost',
                        'username' => 'root',
                        'password' => '',
                        'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''),
                    ),
                ),
            ),
        ),
    ),
    
    'di_paging' => array(
        'instance' => array(
            'Zend\Paginator\Paginator' => array(
                'parameters' => array(
                    'adapter'=>'Zend\Paginator\Adapter\Iterator'
                ),
            ),
            'Zend\Paginator\Adapter\Iterator' => array(
                'parameters' => array(
                    'iterator'=>null
                ),
            ),
        ),
    ),
    
    'messages' => array(
        'post_error' => 'Vaš post nažalost ne može biti prihvaćen',
		'post_confirm' => 'Post je odobren i prikazan na sajtu',
        'post_success'=>'Post je uspešno dodat i čeka na odobrenje',
        'post_failed'=>'Postovanje nije uspelo! Pokušajte ponovo',
        'post_delete'=>'Post je uspešno izbrisan',
        'komentar_error' => 'Morate biti logovani da bi ste komentarisali!',
        'komentar_failed'=>'Neuspešno postavljanje komentara!',
        'komentar_success' => 'Komentar je postavljen!',
        'komentar_delete'=>'Komentar je uspešno izbrisan',
        'register_success' =>'Uspešna registracija',
        'register_error' =>'Greška tokom registracije',
    ),

);
