<?php
namespace Kasjroettest;
/**
 * Description of ModelTest
 *
 * @author jigal
 */

use PHPUnit_Framework_Testcase;


abstract class ModelTestCase extends PHPUnit_Framework_TestCase{
    
    protected $em;
    
    public function setUp(){
        $application = new Application();
    }
    
    
    
    public function tearDown(){
        
    }
    
    
}

