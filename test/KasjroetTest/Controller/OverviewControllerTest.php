<?php
namespace KasjroetTest\Controller;

use KasjroetTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Kasjroet\Controller\OverviewController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use \PHPUnit_Framework_TestCase; 

/**
 * Description of OverviewControllerTest
 *
 * @author jigal
 */
class OverviewControllerTest extends \PHPUnit_Framework_Testcase{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected static $mvcEvent;

    public static function setMvcEvent(MvcEvent $e) {
        self::$mvcEvent = $e;
    }

    public static function getMvcEvent() {

        return self::$mvcEvent;
    }
    public function setUp(){
        
        $serviceManager     = Bootstrap::getServiceManager();
        $this->controller   = new OverviewController();
        $this->controller->setEvent(self::getMvcEvent());
        $this->controller->setServiceLocator( 
                self::getMvcEvent()->getApplication()->getServiceManager()
        );
        $this->request      = new Request();
        $this->routeMatch   = new RouteMatch(array('controller' => 'overview'));
        $this->event        = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }
    
    public function testIndexActionCanBeAccessed(){
        $this->routeMatch->setParam('action', 'index');
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        
        
    }
}
