<?php

namespace Kasjroet\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Kasjroet\Entity\Product as Product;

class OverviewController extends AbstractKasjroetActionController {

    protected $_entityManager;

    public function indexAction() {

        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
        return new ViewModel(array('products' => $repo->listProducts()));
    }

    public function editAction() {

        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', 1);
        
        $product = $repo->find($id);
        $productNames = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup')->findAll();
        $product->SetProductGroup($productNames);
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
     * @param \kasjroet\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->_entityManager = $entityManager;
    }

}
