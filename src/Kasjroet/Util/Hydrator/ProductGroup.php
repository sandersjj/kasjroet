<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 8/6/13
 * Time: 11:37 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\Util\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Kasjroet\Util\Exception\UnsupportedObjectException;

class ProductGroup implements  HydratorInterface{

    /**
     * Extract the values of a product group object
     * @param object $object
     * @return array|void
     * @throws UnsupportedObjectException
     */
    public function extract($object)
    {
        if(!$object instanceof \Kasjroet\Entity\ProductGroup){
            $message = sprintf("The object '%s' is not supported", get_class($object));
            throw new UnsupportedObjectException($message);
        }

        return array(
            'id'                => $object->getId(),
            'productGroupName'  => $object->getProductGroupName()
        );
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        // TODO: Implement hydrate() method.
    }
}