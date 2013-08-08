<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 8/8/13
 * Time: 9:52 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\Util\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Kasjroet\Util\Exception\UnsupportedObjectException;

class Hechsher implements HydratorInterface{



    /**
     * @param object $object
     * @return array|void
     * @throws UnsupportedObjectException
     */
    public function extract($object)
    {
        if(!$object instanceof \Kasjroet\Entity\Hechsher){
            $message = sprintf("The object '%s' is not supported", get_class($object));
            throw new UnsupportedObjectException($message);
        }

        return array(
            'id'                    => $object->getId(),
            'hechsherName'          => $object->getHechsherName(),
            'hechsherDescription'   => $object->getHechsherDescription(),
            'hechsherStamp'         => $object->getHechsherDescription(),
            'url'                   => $object->getUrl()
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