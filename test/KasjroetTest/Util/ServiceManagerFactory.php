<?php

namespace KasjroetTest\Util;


use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Service\ServiceManagerConfig;

use Doctrine\Common\DataFixtures\Purger\ORMPurger as FixturePurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor as FixtureExecutor;

use Doctrine\ORM\Tools\SchemaTool;

class ServiceManagerFactory{

    /**
     * @var array
     */
    protected static $config = array();

    /**
     * @param array $config
     */
    public static function setApplicationConfig(array $config)
    {
        static::$config = $config;
    }


    /**
     * @return array
     */
    public static function getApplicationConfig()
    {
        return static::$config;
    }


    /**
     * @param array $config
     * @return ServiceManager
     */
    public static function getServiceManager(array $config = null)
    {
        $config = $config ?: static::getApplicationConfig();
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                isset(static::$config['service_manager']) ? static::$config['service_manager'] : array()
            )
        );
        $serviceManager->setService('ApplicationConfig', $config);


        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        $serviceManager->setFactory(
            'Doctrine\Common\DataFixtures\Executor\AbstractExecutor',
            function(ServiceLocatorInterface $sl){
                $em = $sl->get('Doctrine\ORM\EntityManager');
                $schemaTool = new SchemaTool($em);
                $schemaTool->createSchema($em->getMetadataFactory()->getAllMetadata());
                return new FixtureExecutor($em, new FixturePurger($em));

            }
        );
        return $serviceManager;
    }
    
}