<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 8/5/13
 * Time: 11:40 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\Util\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;

class ProductGroup implements  HydratorInterface{


    /**
     * @param object $object
     * @return array
     * @throws UnsupportedObjectException
     */
    public function extract($object)
    {
        if (! $object instanceof \Doctrine\Common\Collections\Collection) {
            throw new UnsupportedObjectException();
        }

        $data = [];

        foreach ($object as $key => $value) {
            $data[$key] = $this->postHydrator->extract($value);
        }

        return $data;
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