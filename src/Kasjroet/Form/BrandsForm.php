<?php

namespace Kasjroet\Form;

use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;

class BrandsForm extends Form
{
	public function __construct(ServiceManager $serviceManager, $name = null)
	{
        parent::__construct($name);

		$this->add(array(
			'name' => 'brandName',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Brandname'
			)
		));

		$this->add(array(
			'name' => 'brandName',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Brandname'
			)
		));

        $entityManager = $serviceManager->get('Doctrine\Orm\EntityManager');

        $noObjectExistsValidator = new NoObjectExistsValidator(array(
            'object_repository' => $entityManager->getRepository('Kasjroet\Entity\Brand'),
            'fields'            => 'brandName'
        ));

        $brandNameInput = $this->getInputFilter()->get('brandName');
        $brandNameInput->getValidatorChain()->attach($noObjectExistsValidator);
	}

} 