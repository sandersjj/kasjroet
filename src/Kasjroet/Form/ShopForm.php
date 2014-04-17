<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/17/14
 * Time: 11:00 PM
 */

namespace Kasjroet\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\ServiceManager;
use Zend\Form\Form;


class ShopForm extends Form implements ObjectManagerAwareInterface
{
	protected $objectManager;

	public function init()
	{
		parent::__construct('shopForm');
		$this->setAttribute('method', 'post');

		$this->add(
			array(
				'name' => 'shopName',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Shop name'
				)
			)
		);

		$this->add(
			array(
				'name' => 'street',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Street'
				)
			)
		);

		$this->add(
			array(
				'name' => 'houseNo',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'House number'
				)
			)
		);

		$this->add(
			array(
				'name' => 'zipcode',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Zipcode'
				)
			)
		);


		$this->add(
			array(
				'name' => 'city',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'City'
				)
			)
		);

		$this->add(
			array(
				'name' => 'country',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Country'
				)
			)
		);


		$this->add(
			array(
				'name' => 'phoneNumber',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Phone number'
				)
			)
		);


		$this->add(
			array(
				'name' => 'fax',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Fax'
				)
			)
		);
		$this->add(
			array(
				'name' => 'email',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Email'
				)
			)
		);

		$this->add(
			array(
				'name' => 'website',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => 'Website'
				)
			)
		);


		$this->add(
			array(
				'name' => 'send',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
					'type' => 'submit',
					'value' => 'Submit',
				),
			)
		);


	}

	/**
	 * Get the object manager
	 *
	 * @return ObjectManager
	 */
	public function getObjectManager()
	{
		return $this->objectManager;
	}

	/**
	 * Set the object manager
	 *
	 * @param ObjectManager $objectManager
	 */
	public function setObjectManager(ObjectManager $objectManager)
	{
		$this->objectManager = $objectManager;
	}


} 