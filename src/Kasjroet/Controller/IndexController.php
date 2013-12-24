<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 11/3/13
 * Time: 11:46 PM
 */

namespace Kasjroet\Controller;


use Kasjroet\Form\SearchForm;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractKasjroetActionController{

	public function indexAction(){

		$oForm = new SearchForm();
		$request = $this->getRequest();
		if($request->isPost()){
			$repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
			$searchData = $request->getPost();
			$repo->searchProduct($searchData['search']);
			return new JsonModel(array('result' => $repo->searchProduct($searchData['search'])));

		}
		return new ViewModel(array('form' => $oForm));
	}
}