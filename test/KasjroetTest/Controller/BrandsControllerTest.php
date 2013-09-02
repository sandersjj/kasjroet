<?php
namespace KasjroetTest\Controller;


use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


class BrandsControllerTest extends AbstractHttpControllerTestCase{

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/brand');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Kasjroet');
        $this->assertControllerName('Kasjroet\Controller\Brands');
        $this->assertControllerClass('KasjroetCOntroller');
        $this->assertMatchedRouteName('brands');
    }

}