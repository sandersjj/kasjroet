<?php
namespace KasjroetTest\Controller;


use KasjroetTest\Util\ServiceManagerFactory;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

use Kasjroet\Controller\ProductsRestController;
use Kasjroet\EntityRepository\Product;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

class ProductsRestControllerTest extends AbstractControllerTest
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    /**
     * @var ProductRepository
     */
    protected $repository;

    /**
     * @var \Doctrine\Common\DataFixtures\Executor\AbstractExecutor
     */
    protected $fixtureExectutor;

    protected function setUp()
    {
        try {
            $sm = ServiceManagerFactory::getServiceManager();
            $this->repository = $sm->get('ControllerLoader')->get('Products');
            //$this->fixtureExectutor = $sm->get('Doctrine\Common\DataFixtures\Executor\AbstractExecutor');
            //s$this->assertInstanceOf('Kasjroet\Entity\Product', $this->repository);

        } catch (ServiceNotCreatedException $e) {
            do {
                var_dump($e->getMessage());
            } while ($e = $e->getPrevious());
        }

        $config = $sm->get('Config');

        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($sm);
    }

    public function testGetListCanBeAccessed()
    {
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetCanBeAccessed()
    {
        $this->routeMatch->setParam('id', '1');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateCanBeAccessed()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set('artist', 'foo');
        $this->request->getPost()->set('title', 'bar');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateCanBeAccessed()
    {
        $this->routeMatch->setParam('id', '1');
        $this->request->setMethod('put');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteCanBeAccessed()
    {
        $this->routeMatch->setParam('id', '1');
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}