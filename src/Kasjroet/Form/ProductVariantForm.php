<?php
	namespace Kasjroet\Form;

	use Zend\Form\Form;
	use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
	use Doctrine\Common\Persistence\ObjectManager;
	use DoctrineModule\Persistence\ObjectManagerAwareInterface;
	use Kasjroet\Entity\ProductVariant;



	class ProductVariantForm extends Form implements ObjectManagerAwareInterface
	{
		protected $objectManager;


		public function init()
		{
			parent::__construct('productVariantForm');

			$this->setAttribute('method', 'POST');

			$this->setHydrator(new DoctrineObject($this->getObjectManager(), 'Kasjroet\Entity\ProductVariant'));

			$this->add(
				array(
					'name' => 'id',
					'type' => 'Zend\Form\Element\Hidden',
				)
			);

			$this->add(
				array(
					'name' => 'productId_id',
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