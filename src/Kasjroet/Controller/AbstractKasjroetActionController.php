<?php
namespace Kasjroet\Controller;

Use Zend\Mvc\Controller\AbstractActionController;
/**
 * Description of AbstractActionController
 *
 * @author jigal
 */
class AbstractKasjroetActionController extends AbstractActionController{

    
    public function getModuleConfig(){
        return $this->getServiceLocator()->get('Config');
    }
}
