<?php
namespace Kasjroet\Controller;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\Model\ViewModel;
use Kasjroet\Entity\Product;


class ProductsController extends AbstractKasjroetActionController
{

    public function indexAction()
    {
		if($this->zfcUserAuthentication()->hasIdentity()){

			$id = $this->getEvent()->getRouteMatch()->getParam('id');
			if(isset($id)){
				$product = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->find($id);
				$formElementManager = $this->getServiceLocator()->get('FormElementManager');

				$memoForm = $formElementManager->get('Kasjroet\Form\MemoForm');
				$config = $this->getModuleConfig();

				if (isset($config['kasjroet_form_extra'])) {
					foreach ($config['kasjroet_form_extra'] as $field) {
						$memoForm->add($field);
					}
				}
			}

			return new ViewModel(array(
				'product'           => $product,
				'memoForm'          => $memoForm,
				'isXmlHttpRequest'  => 1
			));
		}
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        $em = $this->getEntityManager();

        $request = $this->getRequest();
        $product = new Product();

		$forms = $this->getServiceLocator()->get('FormElementManager');
		$form = $forms->get('Kasjroet\Form\ProductForm');
		$hydrator = new DoctrineHydrator($em, '\Kasjroet\Entity\Product');
		$form->setHydrator($hydrator);

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
            $this->flashMessenger()->addMessage('The product was updated.');
            return $this->redirect()->toRoute('zfcadmin');
        } else {

            try {
                $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

            } catch (ObjectNotFoundException $e) {
                throw new Exception('Object not found!');
            }

            //@todo review

            $product = $repo->find($id);
			$formManager = $this->getServiceLocator()->get('FormElementManager');
			$form = $formManager->get('Kasjroet\Form\ProductForm');


            $hydrator = $this->getServiceLocator()->get('ProductHydrator');
			$form->setHydrator($hydrator);

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