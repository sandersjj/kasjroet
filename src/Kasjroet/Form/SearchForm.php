<?php

namespace Kasjroet\Form;

use Zend\Form\Form;

class SearchForm extends Form
{

	public function __construct()
	{

		parent::__construct();
		$this->add(array(
			'type' => 'Zend\Form\Element\Text',
			'name' => 'search',
			'options' => array(
				'label' => 'search',
			),
			'attributes' => array(
				'class' => 'search',
				'id' => 'search'

			)
		));

	}

}