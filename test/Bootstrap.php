<?php
namespace KasjroetTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Loader\StandardAutoloader;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
    protected static $serviceManager;
    protected static $config;
    protected static $bootstrap;

    public static function init()
    {
        
        
 
    $previousDir = '.';
    while (!file_exists('config/application.config.php')) {
        $dir = dirname(getcwd());

        if ($previousDir === $dir) {
            throw new RuntimeException(
                'Unable to locate "config/application.config.php":'
                    . ' is the Content module in a sub-directory of your application skeleton?'
            );
        }

        $previousDir = $dir;
        chdir($dir);
}
        if  (!((@include_once __DIR__ . '/../../../../../vendor/autoload.php') || !(@include_once __DIR__ . '/../../../../autoload.php'))) {
           throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
        }

        
        $loader = new StandardAutoloader();
        $loader->registerNamespace('KasjroetTest', __DIR__ . '\KasjroetTest');
        $loader->register();

        // use ModuleManager to load this module and it's dependencies
//        $config = array(
//            'module_listener_options' => array(
//                'module_paths' => $zf2ModulePaths,
//            ),
//            'modules' => array(
//                'DoctrineModule',
//                'DoctrineORMModule',
//                'Kasjroet',
//            )
//        );
        
        if (!$config = @include __DIR__ . '/TestConfiguration.php') {
           $config = require __DIR__ . '/TestConfiguration.php.dist';
        }

        $serviceManager = new ServiceManager(new ServiceManagerConfig(
            isset($config['service_manager']) ? $config['service_manager'] : array()
        ));
        $serviceManager->setService('ApplicationConfig', $config);
        
        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
        
         
        ServiceManagerFactory::setApplicationConfig($config);
        //$sm = ServiceManagerFactory::getServiceManager()->get('Doctrine\ORM\EntityManager');
        
    }
    
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function getConfig()
    {
        return static::$config;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        } else {
            $zf2Path = getenv('ZF2_PATH') ?: (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/ZF2/library') ? $vendorPath . '/ZF2/library' : false));

            if (!$zf2Path) {
                throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
            }

            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();