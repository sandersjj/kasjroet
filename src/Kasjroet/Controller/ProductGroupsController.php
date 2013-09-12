<?php

namespace Kasjroet\Controller;


use Zend\View\Model\ViewModel;

class ProductGroupsController extends AbstractKasjroetActionController{

    public function indexAction(){

        $router = $this->getEvent()->getRouter();
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\ProductGroup');
 return new ViewModel(array(
         'productGroups' => $repo->findAll()
         ));


    }

}