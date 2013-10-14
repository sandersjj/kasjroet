<?php
namespace Kasjroet\Controller;

use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Kasjroet\Controller\AbstractKasjroetActionController;


class OverviewController extends AbstractKasjroetActionController {

    protected $_entityManager;


    public function indexAction() {

        $flashMessages = array();


        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            $flashMessages = $flashMessenger->getMessages();
        }
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
        if(($this->getEvent()->getRouteMatch()->getParam('productgroup'))){
            $products = $repo->getProductsByProductGroup($this->getEvent()->getRouteMatch()->getParam('productgroup'));
        }else{
            $products = $repo->listProducts();
        }



        return new ViewModel(array(
            'products' => $products
            ,'flashMessages' => $flashMessages,
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction(){
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if($id && is_numeric($id)){
             $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
             $repo->removeProduct($id);
        }
        return $this->redirect()->toRoute('overview', array( 'controller' => 'overview', 'action' => 'index'));
    }
    
    /**
     * @return type
     */
    public function getEntityManager() {
        return $this->_entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->_entityManager = $entityManager;
    }

}
