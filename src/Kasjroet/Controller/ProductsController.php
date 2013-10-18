<?php
namespace Kasjroet\Controller;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\Model\ViewModel;


class ProductsController extends AbstractKasjroetActionController
{

    public function indexAction()
    {

        $view = new ViewModel();

        $request = $this->getRequest();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if(isset($id)){
            $em = $this->getEntityManager();
            $product = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->find($id);

            $productView = new  ViewModel(array('product' => $product));
            $productView->setTemplate('kasjroet/products/product');

            $formElementManager = $this->getServiceLocator()->get('FormElementManager');
            $memoForm = $formElementManager->get('Kasjroet\Form\MemoForm');
            $memoView = new ViewModel(array('form' => $memoForm));
            $config = $this->getModuleConfig();
            if (isset($config['kasjroet_form_extra'])) {
                foreach ($config['kasjroet_form_extra'] as $field) {
                    $memoForm->add($field);
                }
            }
            $memoView->setTemplate('Kasjroet\Memo\index');


            $view->addChild($productView, 'product');
            $view->addChild($memoView, 'memo');

        }

        return $view;
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        $em = $this->getEntityManager();

        $request = $this->getRequest();
        $product = new \Kasjroet\Entity\Product;
        $builder = new AnnotationBuilder($em);
        $form = $builder->createForm($product);

        if ($request->isPost() && $this->request->getPost()) {
            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
            $repo->addProduct($this->getRequest()->getPost());
            $this->flashMessenger()->addMessage('The product was added.');
            return $this->redirect()->toRoute('zfcadmin');
        } else {
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
     * @return \Zend\Http\Response|ViewModel
     * @throws Exception
     */
    public function editAction()
    {

        $request = $this->getRequest();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if ($request->isPost() AND is_numeric($id)) {

            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
            $repo->editProduct($id, $this->getRequest()->getPost());
            $this->flashMessenger()->addMessage('The product was edited.');
            return $this->redirect()->toRoute('zfcadmin');
        } else {

            try {
                $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

            } catch (ObjectNotFoundException $e) {
                throw new Exception('Object not found!');
            }

            $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
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


    public function updateAction()
    {

    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if (is_numeric($id))
        {
            $em = $this->getEntityManager();
            $product = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->find($id);
            $em->remove($product);
            $em->flush();
            $this->flashMessenger()->addMessage('The product was removed.');
        }
        return $this->redirect()->toRoute('zfcadmin');
    }

}