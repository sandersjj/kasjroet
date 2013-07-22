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

        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
        return new ViewModel(array('products' => $repo->listProducts()));
    }

    public function editAction() {

        $em = $this->getEntityManager();
        $request = $this->getRequest();

        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if ($request->isPost() AND is_numeric($id))  {
            $productGroupsArray  = $this->params()->fromPost('productGroups');
            $hechsheriemArray = $this->params()->fromPost('hechsheriem');

            $product = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->find($id);
            $product->setProductName($this->params()->fromPost('productName'));
            $product->setDescription($this->params()->fromPost('description'));

            if (!empty($productGroupsArray )) {
                $productGroups = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup')->findList($productGroupsArray );
                $product->setProductGroups($productGroups);
            } else {
                $product->unsetProductsGroups();
            }

            if (!empty($hechsheriemArray )) {
                $hechsheriem = $this->getEntityManager()->getRepository('Kasjroet\Entity\Hechsher')->findList($hechsheriemArray );
                $product->setHechsheriem($hechsheriem);
            } else {
                $product->unsetHechsheriem();
            }

            $em->persist($product);
            $em->flush();

            return $this->redirect()->toRoute('overview', array( 'controller' => 'overview', 'action' => 'index'));
        } else {

            try{
                $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

            }catch(ObjectNotFoundException $e){
                throw new Exception('Object not found!');
            }

            $id = (int) $this->getEvent()->getRouteMatch()->getParam('id', 1);
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

    public function newAction() {
        
        
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
