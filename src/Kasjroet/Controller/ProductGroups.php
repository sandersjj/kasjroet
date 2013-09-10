<?php

namespace Kasjroet\Controller;


use Zend\View\Model\ViewModel;

class ProductGroups extends AbstractKasjroetActionController{

    public function indexAction(){

        $router = $this->getEvent()->getRouter();
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup');
        $url    = $router->assemble(array(), array('name' => 'brand'));
        return new ViewModel(array(
         'productGroups' => $repo->findAll()
          ,'urls' => $url
         ));


    }

}