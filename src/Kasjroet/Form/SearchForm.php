<?php

namespace Kasjroet\Form;

use Zend\Form\Form;

class SearchForm extends Form
{

	public function __construct($name = null)
	{

		parent::__construct('search-form');

		$this->setAttribute('method', 'POST');

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

		$this->add(array(
			'type'	=> 'Zend\Form\Element\Submit',
			'name' => 'submit',
			'attributes' => array(
				'type' 	=> 'Submit',
				'value'	=> 'Opslaan'
			)
		));

	}

}