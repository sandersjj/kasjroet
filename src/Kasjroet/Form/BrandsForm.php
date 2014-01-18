<?php

namespace Kasjroet\Form;

use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class BrandsForm extends Form
{
	public function __construct(ServiceManager $serviceManager, $name = null)
	{
        parent::__construct($name);
        $entityManager = $serviceManager->get('Doctrine\Orm\EntityManager');
        $this->setHydrator(new DoctrineHydrator($entityManager,'Kasjroet\Entity\Brand'));

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




        $noObjectExistsValidator = new NoObjectExistsValidator(array(
            'object_repository' => $entityManager->getRepository('Kasjroet\Entity\Brand'),
            'fields'            => 'brandName'
        ));

        $brandNameInput = $this->getInputFilter()->get('brandName');
        $brandNameInput->getValidatorChain()->attach($noObjectExistsValidator);

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

} 