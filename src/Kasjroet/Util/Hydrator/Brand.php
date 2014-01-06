<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 8/7/13
 * Time: 11:45 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\Util\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;

class Brand implements HydratorInterface{


    public function __construct(){

    }

    /**
     * @param object $object
     * @return array
     * @throws UnsupportedObjectException
     */
    public function extract($object)
    {

        if(!$object instanceof \Kasjroet\Entity\Brand){
            $message = sprintf("The object '%s' is not supported", get_class($object));
            throw new UnsupportedObjectException($message);
        }

        return $object->getBrandName();
        return array(
            'id'    => $object->getId(),
            'brandName' => $object->getBrandName(),
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