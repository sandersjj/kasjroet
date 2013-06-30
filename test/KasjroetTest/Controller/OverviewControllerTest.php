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
use KasjroetTest\Util\ServiceManagerFactory;

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
        
        $serviceManager = ServiceManagerFactory::getServiceManager();
        $this->controller   = new OverviewController();
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
    
    public function tearDown(){
        parent::tearDown();
    }
    
    public function testIndexActionCanBeAccessed(){
        $this->routeMatch->setParam('action', 'index');
        
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testEditActionCanBeAccessed(){
        $this->routeMatch->setParam('action', 'edit');
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testEditActionAcceptsId(){

        $sm = ServiceManagerFactory::getServiceManager();
        $this->repository = $sm->get('Doctrine\ORM\EntityManager')->getRepository('Kasjroet\Entity\Product');
        $this->assertInstanceOf('Kasjroet\EntityRepository\Product', $this->repository);


//
//        $emMock  = $this->getMock('\Doctrine\ORM\EntityManager',
//            array('getRepository', 'getClassMetadata', 'persist', 'flush'), array(), '', false);
//
//            //$em = ServiceManagerFactory::getServiceManager()->get('Doctrine\ORM\EntityManager');
//        $emMock->expects($this->any())
//            ->method('getRepository')
//            ->will($this->returnValue( 'Kasjroet\EntityRepository\Product'));
//
//
//
//           $request = $this->getMockBuilder('Zend\Http\Request')->getMock();
//           $request->expects($this->once())
//                   ->method('getQuery')
//                   ->with(array('id'=> 1))
//                   ->will($this->returnValue('Zend\View\Model'));
//           $this->routeMatch->setParam('action', 'edit');
//           $this->assertEquals('Zend\View\Model', $this->controller->dispatch($request));
    }
}

