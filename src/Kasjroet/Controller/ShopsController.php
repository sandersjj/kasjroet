<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/18/14
 * Time: 9:45 AM
 */

namespace Kasjroet\Controller;


class ShopsController extends AbstractKasjroetActionController
{
	public function ajaxPost()
	{
		$form = new ShopForm();
		if($this->getRequest()->isPost()) {
			$repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Shop');


			var_dump($this->getRequest()->getPost());
		}
	}
} 