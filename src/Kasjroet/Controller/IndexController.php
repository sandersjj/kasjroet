<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 11/3/13
 * Time: 11:46 PM
 */

namespace Kasjroet\Controller;


use Kasjroet\Form\SearchForm;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractKasjroetActionController{

	public function indexAction(){

		$oForm = new SearchForm();
		return new ViewModel(array('form' => $oForm));
	}

} 