<?php

namespace Kasjroet\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\View\Model\ViewModel;
use Kasjroet\Entity\Brand as Brand;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class BrandsController extends AbstractKasjroetActionController{

	/**
	 *
	 * @return array|ViewModel
	 */
	public function indexAction()
	{

		$em = $this->getEntityManager();
		$brands = $em->getRepository('Kasjroet\Entity\Brand')->findAll();

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
		if($this->zfcUserAuthentication()->hasIdentity()){

			$em = $this->getEntityManager();
			$request = $this->getRequest();
			$form = $this->getBrandsForm();
			$brand = new Brand();

            $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');
			$hydrator = new DoctrineHydrator($em, '\Kasjroet\Entity\Brand');

			if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $repo->addBrand($this->params()->fromPost());
                    $this->flashMessenger()->addMessage('The brand was added.');
                    return $this->redirect()->toRoute('zfcadmin/brands');
                }
			} else 	{

                $form->setHydrator($hydrator);
				$form->bind($brand);
			}
            return new ViewModel(array('form' => $form));
		} else {
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
	}

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function editAction()
	{
        $request = $this->getRequest();
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Kasjroet\Form\BrandsForm');

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $repo->updateBrand($id, $this->params()->fromPost());
                $this->flashMessenger()->addMessage('The Brand was updated.');
                return $this->redirect()->toRoute('zfcadmin/brands');
            }
        } else {
            $brand = $this->getEntityManager()->find('Kasjroet\Entity\Brand', $id);
            $form = $formManager->get('Kasjroet\Form\BrandsForm');

            $hydrator = $this->getServiceLocator()->get('BrandHydrator');
            $form->setHydrator($hydrator);
            $form->bind($brand);

            return new ViewModel(array('form' => $form));
        }
    }

    /**
     * @todo to be implemented
     */
    public function deleteAction()
	{
        $repo = $this->getEntityManager()->getRepository('Kasjroet\Entity\Brand');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $result = $repo->removeBrand($id);
        if (!$result) {
            $this->flashMessenger()->addErrorMessage($result);

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
		return $this->getServiceLocator()->get('brandForm');
	}
}