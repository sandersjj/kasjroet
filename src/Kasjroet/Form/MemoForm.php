<?php

namespace Kasjroet\Form;

use Zend\Form\Form;

class MemoForm extends Form
{

	public function __construct()
	{

		parent::__construct();
		$this->add(array(
			'type' => 'Zend\Form\Element\Textarea',
			'name' => 'memo',
			'options' => array(
				'label' => 'Memo',
			),
			'attributes' => array(
				'class' => 'message',
				'id' => 'message'

			)
		));

	}

}