<?php
namespace KasjroetTest\Controller;



use Kasjroet\Controller\BrandsController;
use KasjroetTest\Util\ServiceManagerFactory;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;


class BrandsControllerTest extends AbstractControllerTest{

    public function setUp()
    {

        $serviceManager = ServiceManagerFactory::getServiceManager();
        $this->controller = new BrandsController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);

        parent::setUp();

    }

    public function testIndexActionCanBeAccessed()
    {

    }

}