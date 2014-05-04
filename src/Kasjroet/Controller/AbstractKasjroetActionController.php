<?php
namespace Kasjroet\Controller;

Use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of AbstractActionController
 *
 * @author jigal
 */
class AbstractKasjroetActionController extends AbstractActionController{

    protected $_entityManager;


    public function getModuleConfig(){
        return $this->getServiceLocator()->get('Config');
    }

    /**
     * @return type
     */
    public function getEntityManager() {
        return $this->_entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->_entityManager = $entityManager;
    }
}
