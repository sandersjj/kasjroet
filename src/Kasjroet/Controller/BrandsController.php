<?php

namespace Kasjroet\Controller;


use Zend\View\Model\ViewModel;

class BrandsController extends AbstractKasjroetActionController{

    public function indexAction(){
        return new ViewModel(array());
    }

}