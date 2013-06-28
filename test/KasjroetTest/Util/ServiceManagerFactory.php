<?php

namespace KasjroetTest\Util;

 
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Service\ServiceManagerConfig;
 
use Doctrine\Common\DataFixtures\Purger\ORMPurger as FixturePurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor as FixtureExecutor;

class ServiceManagerFactory{
    
    private static $config = array();
    
    public static function getServiceManager(array $config = null){
        
        $config = $config ?: static::getApplicationConfig();
        $serviceManager = new ServiceManager(new ServiceManagerConfig(
                isset($config['service_manager']) ? $config['service_manager'] : array()
                
        ));
        
        $serviceManager->setService('ApplicationConfig' , $config);
        
        /* @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
        
        $serviceManager->setFactory(
               'Doctrine\Common\DataFixtures\Executor\AbstractExecutor',
                function(ServiceLocatorInterface $sl){
                    $em = $sl->get('Doctrine\Orm\EntityManager');
                    $schamaTool = new SchemaTool($em);
                    $schemaTool->createSchema($em->getMetadataFactory()->getAllMetadata());
                    return new FixtureExecutor($em, new FixturePurger($em));
                }
                
                
        );
        
        return $serviceManager;
        
    }
    
    /**
     * @static
     * @return array
     */
    public static function getApplicationConfig(){
        return static::$config;
    }
    /**
     * @static
     * @param array$config
     */
    public static function setApplicationConfig($config){
        static::$config = $config;
    }
    
}