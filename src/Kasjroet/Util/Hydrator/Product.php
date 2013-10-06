<?php
/**
 *
 * User: jigal
 * Date: 8/5/13
 * Time: 9:25 PM
 *
 */

namespace Kasjroet\Util\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;

class Product implements HydratorInterface {

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $brandHydrator;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $productGroupsHydrator;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $hechsherHydrator;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $memoHydtrator;

    /**
     * @param HydratorInterface $productGroupsHydrator
     * @param HydratorInterface $brandHydrator
     * @param HydratorInterface $hechsherHydrator
     */
    public function __construct(HydratorInterface $productGroupsHydrator, HydratorInterface $brandHydrator,
                                HydratorInterface $hechsherHydrator){
        $this->brandHydrator            = $brandHydrator;
        $this->productGroupsHydrator    = $productGroupsHydrator;
        $this->hechsherHydrator         = $hechsherHydrator;
        //$this->memoHydtrator        = $memoHydtrator;
    }


    /**
     * @param object $object
     * @return array
     * @throws UnsupportedObjectException
     */
    public function extract($object){
        if(!$object instanceof \Kasjroet\Entity\Product){
            throw new UnsupportedObjectException();
        }

        return array(
          'id'              => $object->getId(),
          'productName'     => $object->getProductName(),
          'description'     => $object->getDescription(),
          'visible'         => $object->getVisible(),
          'brand'           => $this->brandHydrator->extract($object->getBrand()),
          'productGroups'   => $this->productGroupsHydrator->extract($object->getProductGroups()),
          'hechsheriem'     => $this->hechsherHydrator->extract($object->getHechsheriem())
          //'memos'           => $this->memoHydrator($object->getMemos())

        );
    }

    public function hydrate(array $data, $object){

    }
}