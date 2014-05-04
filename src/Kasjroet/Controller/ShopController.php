<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/18/14
 * Time: 9:45 AM
 */
namespace Kasjroet\Controller;

use Kasjroet\Entity\Shop;
use Kasjroet\Form\ShopForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ShopController extends AbstractActionController
{

	public function ajaxAction()
	{
		$request = $this->getRequest();
		$aReturnArray = array();
		if ($this->getRequest()->isXmlHttpRequest()) {
			$form = new ShopForm();
			if ($request->isPost() && $request->getPost()) {
				$form->setData($request->getPost());

				if($form->isValid()) {
					$postData = json_decode($request->getContent());

					//@todo: this should be refacored
					if(is_object($postData)) {
						$postData = get_object_vars($postData);
					}
					$repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Shop');
					$entityManager = $this->getEntityManager();
					$hydrator = new DoctrineHydrator($entityManager, 'Kasjroet\Entity\Shop');
					$shop = new Shop();
					$shop = $hydrator->hydrate($postData, $shop);

					$entityManager->persist($shop);
					$entityManager->flush();

					$aReturnArray['status'] = 'success';
					$shopName = $shop->getShopName();
					if((trim($shop->getStreet())) !== "") {
						$shopName .= sprintf(" ( %s ) ", $shop->getStreet());
					}
					$aReturnArray['shop'] = array('id' => $shop->getId(), 'name' => $shopName) ;

				} else {
					$aReturnArray['status']  = 'error';
					$aReturnArray['message']  = 'Het formulier kon niet worden opgeslagen';
				}

			} else {
				$aReturnArray['status']  = 'error';
				$aReturnArray['shopForm'] = $form;

			}

			return  new JsonModel($aReturnArray);

		}
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
	public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
		$this->_entityManager = $entityManager;
	}
} 