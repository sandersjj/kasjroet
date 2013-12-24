<?php

namespace Kasjroet\Controller;

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

            $config = $this->getModuleConfig();
            if (isset($config['kasjroet_form_extra'])) {
                foreach ($config['kasjroet_form_extra'] as $field) {
                    $form->add($field);
                }
            }

            return new ViewModel(array('form' => $form));
		}
	}

	public function editAction()
	{

	}

	public function deleteAction()
	{

	}

	private function getBrandsForm()
	{
		return $this->getServiceLocator()->get('brandForm');
	}
}