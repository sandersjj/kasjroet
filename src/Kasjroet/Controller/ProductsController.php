<?php
namespace Kasjroet\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Kasjroet\Entity\Product;
use Kasjroet\Form\ShopForm;
use Zend\View\Model\ViewModel;


class ProductsController extends AbstractKasjroetActionController
{

	public function indexAction()
	{

		$products = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->findAll();
		return new ViewModel(array(
			'products' => $products
		));
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

			$aViewVars = array(
				'form' => $form,
				'product' => $product
			);

			$productView = new ViewModel();
			$productView->setVariables($aViewVars);
			$productView->setTemplate('kasjroet/products/product');
			$shopView = new ViewModel();
			$shopView->setVariable('shopForm', $this->getForm('ShopForm'));
			$shopView->setTemplate('kasjroet/shops/new');
			$view = new ViewModel();

			$view->addChild($shopView, 'shop')
				->addChild($productView, 'productView');


			$view->setTemplate('kasjroet/products/edit.phtml');

			return $view;
		}
	}

	/**
	 * @return \Zend\Http\Response|ViewModel
	 * @throws Exception
	 */
	public function editAction()
	{
		$request = $this->getRequest();
		$repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		$form = $this->getForm('ProductForm');
		$formElementManager = $this->getServiceLocator()->get('FormElementManager');
		//$memoForm = $formElementManager->get('memoForm');
		$memoForm = null;

		if (! $request->isPost() ) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$repo->editProduct($id, $this->params()->fromPost());
				$this->flashMessenger()->addMessage('The Product was updated');
				return $this->redirect()->toRoute('zfcadmin/products');
			} else {
				$product = $this->getEntityManager()->find('Kasjroet\Entity\Product', $id);
				$form->bind($product);
			}

		} else {
			$product = $this->getEntityManager()->find('Kasjroet\Entity\Product', $id);
			$form->bind($product);
		}


		$view = new viewModel();
		$view->setVariable('productVariantForm' , $this->getForm('ProductVariantForm'));
		$productView = new ViewModel();
		$aViewVars = array(
			'product' => $product,
			'memoForm' => $memoForm,
			'form' => $form,
			'isXmlHttpRequest' => 1,

		);
		$productView->setVariables($aViewVars);
		$productView->setTemplate('kasjroet/products/product');

		$shopView = new ViewModel();
		$shopView->setVariable('shopForm', $this->getForm('ShopForm'));
		$shopView->setTemplate('kasjroet/shops/new');

//		$productVariantView = new ViewModel();
//		$productVariantView->setVariable('productVariantForm', $this->getForm('ProductVariantForm'));
//		$productVariantView->setTemplate('kasjroet/product-variant/new.phtml');


		$view->addChild($shopView, 'shop')
			->addChild($productView, 'productView');
//			->addChild($productVariantView, 'productVariant');
		return $view;

	}


	public function updateAction()
	{

	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		if (is_numeric($id)) {
			$em = $this->getEntityManager();
			$product = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product')->find($id);
			$em->remove($product);
			$em->flush();
			$this->flashMessenger()->addMessage('The product was removed.');
		}
		return $this->redirect()->toRoute('zfcadmin');
	}

	/**
	 * Returns the product form
	 * @return mixed
	 */

	private function getForm($form)
	{
		$formElementManager = $this->getServiceLocator()->get('FormElementManager');
		return $formElementManager->get($form);
	}

}