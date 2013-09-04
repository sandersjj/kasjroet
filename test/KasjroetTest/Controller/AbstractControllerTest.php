<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jigal
 * Date: 9/4/13
 * Time: 11:17 AM
 * To change this template use File | Settings | File Templates.
 */

namespace KasjroetTest\Controller;


use Zend\Http\Request;
use Zend\Http\Response;

use PHPUnit_Framework_TestCase;


abstract class AbstractControllerTest extends PHPUnit_Framework_TestCase{

    protected $request;
    protected $routeMatch;
    protected $controller;
    protected $event;

    protected  function setUp() {


    }

}