<?php

namespace Kasjroet\Controller;

use Zend\Mvc\Controller\AbstractRestfulcontroller as AbstractRestfulcontroller;
use Zend\EventManager\EventManagerInterface;
use Doctrine\ORM\EntityManager;

/**
 * Description of AbstractKasjroetRestController
 *
 * @author jigal
 */
class AbstractKasjroetRestController extends AbstractRestfulcontroller {

    protected $_entityManager;
    protected $allowedCollectionMethods = array('GET', 'POST');
    protected $allowedResourceMethods = array('GET', 'PATCH', 'PUT', 'DELETE');

    
    

    // configure response
    public function getResponseWithHeader() {
        $response = $this->getResponse();
        $response->getHeaders()
                //make can accessed by *   
                ->addHeaderLine('Access-Control-Allow-Origin', '*')
                //set allow methods
                ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');
        return $response;
    }
    
    
    public function getEntityManager() {
        return $this->_entityManager;
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->_entityManager = $entityManager;
    }

    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);
        $events->attach('dispatch', array($this, 'checkOptions'), 10);
        $events->attach('dispatch', array($this, 'injectLinkHeader'), 10);
    }

    public function checkOptions($e) {
        $matches = $e->getRouteMatch();
        $response = $e->getResponse();
        $request = $e->getRequest();
        $method = $request->getMethod();
        
        if ($matches->getParam('id', false)) {
            if (!in_array($method, $this->allowedResourceMethods)) {
                $response->setStatusCode(405);
                return $response;
            }
        }

        if (!in_array($method, $this->allowedCollectionMethods)) {
            $response->setStatusCode(405);
            return $response;
        }
    }

    public function injectLinkHeader($e) {
        $response = $e->getResponse();
        $headers = $response->getHeaders();
//        $headers->addHeaderLine('Link', sprintf('<%s>; rel="describedBy"', $this->url('documentation-route-name')));
    }

    public function create($data) {
        
    }

    public function delete($id) {
        
    }

    public function get($id) {
        
    }

    public function getList() {
        
    }

    public function update($id, $data) {
        
    }

}

