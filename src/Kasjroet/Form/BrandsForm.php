<?php

namespace Kasjroet\Form;

use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;

class BrandsForm extends Form
{
    public function init()
	{


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

        $this->add(array(
                'name' => 'send',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Submit',
                ),
            ));

        $serviceManager = $this->getFormFactory()->getFormElementManager()->getServiceLocator();
        $entityManager = $serviceManager->get('Doctrine\Orm\EntityManager');

        $noObjectExistsValidator = new NoObjectExistsValidator(array(
            'object_repository' => $entityManager->getRepository('Kasjroet\Entity\Brand'),
            'fields'            => 'brandName'
        ));

        $brandNameInput = $this->getInputFilter()->get('brandName');
        $brandNameInput->getValidatorChain()->attach($noObjectExistsValidator);
	}

} 