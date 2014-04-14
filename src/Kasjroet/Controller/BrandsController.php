<?php
namespace Kasjroet\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\View\Model\ViewModel;
use Kasjroet\Entity\Brand as Brand;


class BrandsController extends AbstractKasjroetActionController{

	/**
	 *
	 * @return array|ViewModel
	 */
	public function indexAction()
	{
        $flashMessages = array();
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {
            $flashMessages = $flashMessenger->getMessages();
        }

		$em = $this->getEntityManager();
		$brands = $em->getRepository('Kasjroet\Entity\Brand')->findAll();

        $this->layout()->setVariable('flashMessages', $flashMessages);

        return new ViewModel(
			array(
				'brands' => $brands,
			)
		);
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function newAction()
	{
			$request = $this->getRequest();
			$form = $this->getBrandsForm();
			$brand = new Brand();

            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');

			if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $repo->addBrand($this->params()->fromPost());
                    $this->flashMessenger()->addMessage('The brand was added.');
                    return $this->redirect()->toRoute('zfcadmin/brands');
                }
			} else 	{
        		$form->bind($brand);
			}
            return new ViewModel(array('form' => $form));
	}

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function editAction()
	{
        $request = $this->getRequest();
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $form = $this->getBrandsForm();


        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $repo->updateBrand($id, $this->params()->fromPost());
                $this->flashMessenger()->addMessage('The Brand was updated.');
                return $this->redirect()->toRoute('zfcadmin/brands');
            }
        } else {
            $brand = $this->getEntityManager()->find('Kasjroet\Entity\Brand', $id);
            $form->bind($brand);

            return new ViewModel(array('form' => $form));
        }
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
	{


        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $result = $repo->removeBrand($id);


        if (is_string($result)) {
            $this->flashMessenger()->addMessage($result);

            return $this->redirect()->toRoute('zfcadmin/brands');
        }

        $this->flashMessenger()->addMessage('The Brand was deleted.');
        return $this->redirect()->toRoute('zfcadmin/brands');
	}

    /**
     * @todo to be implemented
     */
	private function getBrandsForm()
	{
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        return $formManager->get('BrandsForm');
	}
}