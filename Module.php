<?php

namespace Kasjroet;

use Kasjroet\Controller\AbstractKasjroetActionController;
use Kasjroet\Form\ProductForm;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\ModuleManager\ModuleManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class module
{

    protected $whitelist = array( 'kasjroet' , 'zfcuser/login',);

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $controllerLoader = $serviceManager->get('ControllerLoader');

        // Add initializer to Controller Service Manager that check if controllers needs entity manager injection
        $controllerLoader->addInitializer(function ($instance) use ($serviceManager) {
                if (method_exists($instance, 'setEntityManager')) {
                    $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
                }
         });



        $app = $e->getApplication();
        $em  = $app->getEventManager();
        $sm  = $app->getServiceManager();

        $list = $this->whitelist;
        $auth = $sm->get('zfcuser_auth_service');

        $em->attach(MvcEvent::EVENT_ROUTE, function($e) use ($list, $auth) {

                $match = $e->getRouteMatch();

                // No route match, this is a 404
                if (!$match instanceof RouteMatch) {
                    return;
                }

                // Route is whitelisted
                $name = $match->getMatchedRouteName();
                if (in_array($name, $list)) {
                    return;
                }

                // User is authenticated
                if ($auth->hasIdentity()) {
                    return;
                }

                // Redirect to the user login page, as an example
                $router   = $e->getRouter();
                $url      = $router->assemble(array(), array(
                        'name' => 'zfcuser/login'
                    ));

                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);

                return $response;
        }, -100);
		$em->attach(MvcEvent::EVENT_RENDER, function($e) {
				$flashMessenger = new FlashMessenger();

				$messages = array();

				$flashMessenger->setNamespace('success');
		 		if ($flashMessenger->hasMessages()) {
					$messages['success'] = $flashMessenger->getMessages();
				}
				$flashMessenger->clearMessages();

				$flashMessenger->setNamespace('info');
				if ($flashMessenger->hasMessages()) {
					$messages['info'] = $flashMessenger->getMessages();
				}
				$flashMessenger->clearMessages();

				$flashMessenger->setNamespace('default');
				if ($flashMessenger->hasMessages()) {
					if (isset($messages['info'])) {
						$messages['info'] = array_merge($messages['info'], $flashMessenger->getMessages());
					}
					else {
						$messages['info'] = $flashMessenger->getMessages();
					}
				}
				$flashMessenger->clearMessages();

				$flashMessenger->setNamespace('error');
				if ($flashMessenger->hasMessages()) {
					$messages['error'] = $flashMessenger->getMessages();
				}
				$flashMessenger->clearMessages();

				$e->getViewModel()->setVariable('flashMessages', $messages);
			});
    }



    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            if ($controller instanceof Controller\AbstractKasjroetActionController) {
                $controller->layout('layout/frontend');
            }
        }, 100);
    }

    public function getViewHelperConfig()
    {
        return array(
          'invokables' => array(
              'memoForm' => 'Kasjroet\View\Helper\Memo'
        ),
        'factories' => array(
            'getMemoForm' => function($helperPluginManager){
                $serviceLocator = $helperPluginManager->getServiceLocator();
                $viewHelper = new View\Helper\Memo();
                $viewHelper->setServiceLocator($serviceLocator);
                return $viewHelper;
            }
        ));

    }

    public function getFormElementConfig()
    {
        return array(
			'invokables' => array(
				'productForm' => 'Kasjroet\Form\ProductForm'
			),
            'initializers' => array(
                'ObjectManagerInitializer' => function ($element, $formElements) {
                        if ($element instanceof ObjectManagerAwareInterface) {
                            $services = $formElements->getServiceLocator();
                            $entityManager = $services->get('Doctrine\ORM\EntityManager');
                            $element->setObjectManager($entityManager);
                        }
                    },
            ),
//            'factories' => array(
//                'ProductForm' => function ($sm) {
//                        $productForm = new ProductForm($sm);
//                        return $productForm;
//                    }
//            ),

        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
//                'productForm' => function($sm){
//
//						$productForm->setObjectManager($sm->get('Doctrine\ORM\EntityManager'));
//                        return $productForm;
//                },
                'BrandsForm'   => function($sm){
                       return new Form\BrandsForm($sm);
                },
                'ProductHydrator' => function ($sm) {
                        return new Util\Hydrator\Product(
                            new Util\Hydrator\ProductGroups(new Util\Hydrator\ProductGroup()),
                            new Util\Hydrator\Brand(),
                            new Util\Hydrator\Hechsheriem(new Util\Hydrator\Hechsher())
                        );
                },
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
