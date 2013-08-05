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
    private $productGroupHydrator;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $hechsherHydrator;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    private $memoHydtrator;

    /**
     * @param HydratorInterface $brandHydrator
     * @param HydratorInterface $productGroupHydrator
     * @param HydratorInterface $hechsherHydrator
     * @param HydratorInterface $memoHydtrator
     */
    public function __construct(HydratorInterface $brandHydrator, HydratorInterface $productGroupHydrator,
                                HydratorInterface $hechsherHydrator, HydratorInterface $memoHydtrator){
        $this->brandHydrator        = $brandHydrator;
        $this->productGroupHydrator = $productGroupHydrator;
        $this->hechsherHydrator     = $hechsherHydrator;
        $this->memoHydtrator        = $memoHydtrator;
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
          'productGroups'   => $this->productGroupHydrator->extract($object->getProductGroups()),
          'memos'           => $this->memoHydrator($object->getMemos())

        );
    }

    public function hydrate(array $data, $object){

    }
}