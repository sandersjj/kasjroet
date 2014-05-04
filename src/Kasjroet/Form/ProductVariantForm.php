<?php
namespace Kasjroet\Form;

use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ProductVariantForm extends Form
{
	public function init()
	{
		parent::__construct('productVariantForm');

		$this->setAttribute('method', 'POST');

		$this->setHydrator(new DoctrineObject($this->getObjectManager(), 'Kasjroet\Enitty\ProductVariant'));

		$this->add(
			array(
				'name' => 'id',
				'type' => 'Zend\Form\Element\Hidden',
			)
		);

		$this->add(
			array(
				'name' => 'name',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Name'
				)
			)
		);

		$this->add(
			array(
				'name' => 'description',
				'type' => 'Zend\Form\Element\TextArea',
				'options' => array(
					'label' => 'Product name'
				)
			)
		);

		$this->add(
			array(
				'name' => 'visible',
				'type' => 'Zend\Form\Element\Checkbox',
				'options' => array(
					'label' => 'Visible'
				)
			)
		);
	}
} 