<?php

namespace Kasjroet;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class module {

    public function onBootstrap(MvcEvent $e) {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $controllerLoader = $serviceManager->get('ControllerLoader');

        // Add initializer to Controller Service Manager that check if controllers needs entity manager injection
        $controllerLoader->addInitializer(function ($instance) use ($serviceManager) {
                if (method_exists($instance, 'setEntityManager')) {
                    $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
                }
         });
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function init(ModuleManager $moduleManager){
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            if ($controller instanceof Controller\AbstractKasjroetActionController) {
                $controller->layout('layout/frontend');
            }
        }, 100);
    }

    public function getViewHelperConfig(){
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


    public function getAutoloaderConfig() {
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
