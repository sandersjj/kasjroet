<?php
namespace Kasjroet\Controller;

use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Kasjroet\Controller\AbstractKasjroetActionController;


class OverviewController extends AbstractKasjroetActionController
{

    protected $_entityManager;


    public function indexAction()
    {

		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return $this->redirect()->toRoute('zfcuser/login');
		}

        $flashMessages = array();
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {
            $flashMessages = $flashMessenger->getMessages();
        }

        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');

        if (($this->getEvent()->getRouteMatch()->getParam('productgroup'))) {
            $products = $repo->getProductsByProductGroup($this->getEvent()->getRouteMatch()->getParam('productgroup'));
        } else{
            $products = $repo->listProducts();
        }
        $this->layout()->setVariable('flashMessages', $flashMessages);

        return new ViewModel(array(
            'products' => $products,
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');

        if ($id && is_numeric($id)) {
             $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Product');
             $repo->removeProduct($id);
        }

        return $this->redirect()->toRoute('overview', array( 'controller' => 'overview', 'action' => 'index'));
    }


}
