<?php
namespace Kasjroet\Controller;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;

class ProductsController extends AbstractKasjroetActionController{

    public function indexAction(){

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


    public function updateAction(){

    }

    public function deleteAction(){

    }

}