<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 8/6/13
 * Time: 11:47 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Kasjroet\Util\Exception;


class UnsupportedObjectException extends \Exception{

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}