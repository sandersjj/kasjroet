<?php
namespace KasjroetTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Loader\StandardAutoloader;
use KasjroetTest\Util\ServiceManagerFactory;

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
        static::initAutoloader();

        if (!$config = @include __DIR__ . '/TestConfiguration.php') {
            $config = require __DIR__ . '/TestConfiguration.php.dist';
        }

        $loader = new StandardAutoloader();
        $loader->registerNamespace('KasjroetTest', __DIR__ . 'KasjroetTest');
        $loader->registerNamespace('Kasjroet', __DIR__ . 'Kasjroet');
        $loader->register();

        $serviceManager = new ServiceManager(new ServiceManagerConfig(
            isset($config['service_manager']) ? $config['service_manager'] : array()
        ));
        $serviceManager->setService('ApplicationConfig', $config);
        
        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
        ServiceManagerFactory::setApplicationConfig($config);
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

        $zf2Path = getenv('ZF2_PATH');
        if (!$zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            } elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
                $zf2Path = $vendorPath . '/zendframework/zendframework/library';
            }
        }

        if (!$zf2Path) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
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