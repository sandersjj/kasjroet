<?php

namespace Kasjroet\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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

        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
        return new ViewModel(array('products' => $repo->listProducts()));
    }

    public function editAction() {

        $em = $this->getEntityManager();
        $request = $this->getRequest();
        if($request->isPost() && (int) $this->getEvent()->getRouteMatch()->getParam('id'))  {


            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
            $product = $repo->find($id);
            $product->setProductName($this->params()->fromPost('productName'));
            $product->setDescription($this->params()->fromPost('description'));

            $productGroups  = array();
            if($this->params()->fromPost('productGroups')){
                $productGroups = $this->params()->fromPost('productGroups');
            }


            if(!empty($productGroups)){
                foreach($this->params()->fromPost('productGroups') as $productGroup){
                    $productGroupRepo = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup');
                    $productGroupObject = $productGroupRepo->find((int)$productGroup);

                    $product->addProductGroup($productGroupObject);
                }
            }

            $hechsheriem = array();
            if($this->params()->fromPost('hechsheriem')){
                $hechsheriem = $this->params()->fromPost('hechsheriem');
            }

            if(!empty($hechsheriem)){
                foreach($this->params()->fromPost('hechsheriem') as $hechsher){
                    $hechsherimpRepo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Hechsher');
                    $hechsherObject = $hechsherimpRepo->find((int)$hechsher);
                    $product->addHechsher($hechsherObject);
                }
            }



            $em->persist($product);
            $em->flush();


        }


        try{
            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

        }catch(ObjectNotFoundException $e){
            throw new Exception('Object not found!');
        }

        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', 1);
        $product = $repo->find($id);
        $productNames = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup')->findAll();

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

    public function newAction() {
        
        
        $product = new \Kasjroet\Entity\Product;
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm($product);

        return new ViewModel(array('form' => $form));
    }

    /**
     * @return type
     */
    public function getEntityManager() {
        return $this->_entityManager;
    }

    /**
     * 
     * @param Kasjroet\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->_entityManager = $entityManager;
    }

}
