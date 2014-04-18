<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/18/14
 * Time: 9:45 AM
 */
namespace Kasjroet\Controller;

use Kasjroet\Form\ShopForm;
use Zend\View\Model\JsonModel;


class ShopController extends AbstractKasjroetActionController
{
	public function ajaxAction()
	{

		$form = new ShopForm();
		if($this->getRequest()->isPost()) {
			$repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Shop');


			//var_dump($this->getRequest()->getPost());
		}

		$json = new JsonModel(array(
		'result' => 'hallo wereld!'
	));
        return $json;
	}
} 