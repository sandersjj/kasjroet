<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/18/14
 * Time: 9:45 AM
 */
namespace Kasjroet\Controller;

use Kasjroet\Form\ProductVariantForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager as EntityManager;
use Kasjroet\Service\ProductVariantService;

class ProductVariantController extends AbstractActionController
{
	private $entityManger;
	private $productVariantService;

	public function __construct()
	{

	}

	public function showFormAction()
	{
		$id = $this->params()->fromRoute('id');
		$form = new ProductVariantForm();
		try {
			$productVariant = $this->getProductVariantService()->get($id);
//			$hydrator = new DoctrineHydrator($this->getEntityManager(), '\Kasjroet\Entity\ProductVariant');
//			$form->setHydrator($hydrator);
			$form->bind($productVariant);

		} catch(\InvalidArgumentException $e) {
			var_dump($e->getMessage());
		}

		$viewModel = new JsonModel(array('form' => $form));
		return $viewModel;
	}


	public function ajaxAction()
	{
		$pv = $this->productVariantService->get(2);
		return json_encode($this->productVariantService->get(2));
		var_dump($this->shopService->get(2));
		exit;


		/**
		 * @var \Zend\Http\Request
		 */
		$request = $this->getRequest();
		$aReturnArray = array();

		if ($request->isXmlHttpRequest()) {
			$form = new ProductVariantForm();
			if ($request->isPost() && $request->getPost()) {
				$form->setData($request->getPost());

				if ($form->isValid()) {
					$postData = json_decode($request->getContent());

					if(is_object($postData)) {
						$postData = get_object_vars($postData);
					}
						$entityManager = $this->getEntityManager();
						$hydrator = new DoctrineHydrator($entityManager, 'Kasjroet\Entity\ProductVariant');
						$productVariant = new ProductVariant();
						$productVariant = $hydrator->hydrate($postData, $productVariant);

						$entityManager->persist($productVariant);
						$entityManager->flush();

						$aReturnArray['status'] = 'success';

						$aReturnArray['productVariantName'] =$productVariantName = $productVariant->getName();
						$aReturnArray['productVariantID'] = $productVariantName = $productVariant->getId();
					} else {
						$aReturnArray['status']  = 'error';
						$aReturnArray['message']  = 'De variant kon niet worden opgeslagen';
					}
				} else {
					$aReturnArray['status']  = 'error';
					$aReturnArray['shopForm'] = $form;
				}
				return  new JsonModel($aReturnArray);

			}
		}
	  

	public function setProductVariantService(ProductVariantService $pvService)
	{
		$this->productVariantService = $pvService;
	}

	public function getProductVariantService()
	{
		return isset($this->productVariantService) ? $this->productVariantService : null;
	}


	/**
	 * @return type
	 */
	public function getEntityManager() {
		return $this->entityManager;
	}

	/**
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function setEntityManager(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
} 