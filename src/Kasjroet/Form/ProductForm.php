<?php


namespace Kasjroet\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Form;


class ProductForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function init($name = null)
    {

        $this->setAttribute('method', 'POST');


        $this->add(
            array(
                'name' => 'id',
            )
        );

        $this->add(
            array(
                'name' => 'brand',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Brand',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Kasjroet\Entity\Brand',
                    'property' => 'brandName'
                ),
                'attributes' => array(
                    'multiple' => 'multiple',
                ),

            )
        );

        $this->add(
            array(
                'name' => 'productGroups',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Productgroups',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Kasjroet\Entity\ProductGroup',
                    'property' => 'productGroupName'
                ),
                'attributes' => array(
                    'multiple' => 'multiple',
                ),

            )
        );
        $this->add(
            array(
                'name' => 'tags',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Tags',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Kasjroet\Entity\Tag',
                    'property' => 'tag'
                ),
                'attributes' => array(
                    'multiple' => 'multiple',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'productName',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' => 'Product name'
                )
            )
        );

        $this->add(
            array(
                'name' => 'description',
                'type' => 'Zend\Form\Element\Textarea',
                'options' => array(
                    'label' => 'Description'
                )
            )
        );

        $this->add(
            array(
                'name' => 'hechsheriem',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => 'Hechsheriem',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Kasjroet\Entity\Hechsher',
                    'property' => 'hechsherName'
                ),
                'attributes' => array(
                    'multiple' => 'multiple',
                ),
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
                'name' => 'update',
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'label' => 'Mark for update'
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