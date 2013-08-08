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

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        var_dump($object);
        exit;
        return array(
            'id'    => $object->getId(),
            'brandName' =>$object->getBrandName(),
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