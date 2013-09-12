<?php

namespace Kasjroet\Controller;

use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Kasjroet\Entity\Product as Product;
use Kasjroet\Controller\AbstractKasjroetActionController;
use ZendTest\XmlRpc\Server\Exception;

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
     * @return \Zend\Http\Response|ViewModel
     * @throws \ZendTest\XmlRpc\Server\Exception
     */
    public function editAction() {

        $request = $this->getRequest();


        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if ($request->isPost() AND is_numeric($id))  {

            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
            $repo->editProduct($id, $this->getRequest()->getPost());
            $this->flashMessenger()->addMessage('The product was edited.');
            return $this->redirect()->toRoute('overview', array( 'controller' => 'overview', 'action' => 'index'));
        } else {

            try{
                $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

            }catch(ObjectNotFoundException $e){
                throw new Exception('Object not found!');
            }

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
            $product = $repo->find($id);

            $builder = new AnnotationBuilder($this->getEntityManager());
            $form = $builder->createForm($product);

            $config = $this->getModuleConfig();
            if (isset($config['kasjroet_form_extra'])) {
                foreach ($config['kasjroet_form_extra'] as $field) {
                    $form->add($field);
                }
            }
            $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Kasjroet\Entity\Product'));
            $form->bind($product);
            return new ViewModel(array('form' => $form));

        }
    }

    /**
     * @return ViewModel
     */
    public function newAction() {

        $request = $this->getRequest();
        if($request->isPost()){
            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
            $repo->addProduct($this->getRequest()->getPost());
            $this->flashMessenger()->addMessage('The product was added.');
            return $this->redirect()->toRoute('overview', array( 'controller' => 'overview', 'action' => 'index'));
        }else{
            $product = new \Kasjroet\Entity\Product;
            $builder = new AnnotationBuilder($this->getEntityManager());
            $form = $builder->createForm($product);

            $config = $this->getModuleConfig();
            if (isset($config['kasjroet_form_extra'])) {
                foreach ($config['kasjroet_form_extra'] as $field) {
                    $form->add($field);
                }
            }
            return new ViewModel(array('form' => $form));
        }
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
