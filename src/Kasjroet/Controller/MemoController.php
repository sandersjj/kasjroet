<?php
namespace Kasjroet\Controller;


use Zend\View\Model\JsonModel;
use Kasjroet\Entity\Memo;
use Zend\Json\Json;

class MemoController extends AbstractKasjroetActionController
{
    public function memoAction(){
        $em = $this->getEntityManager();

        $Memo = new Memo();
        $builder = new AnnotationBuilder($em);
        $form = $builder->createForm($Memo);

        $config = $this->getModuleConfig();
        if (isset($config['kasjroet_form_extra'])) {
            foreach ($config['kasjroet_form_extra'] as $field) {
                $form->add($field);
            }
        }
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Kasjroet\Entity\Memo'));
        $form->bind($Memo);
        return new ViewModel(array('form' => $form));
    }


	public function validatepostajaxAction(){
		$result = array();

		$jsonModel = new JsonModel();

		if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();

			/**
			 * @var \Doctrine\ORM\EntityManager
			 */
			$em = $this->getEntityManager();
			$product = $em->getRepository('\Kasjroet\Entity\Product')->find($data['product_id']);
			$memo = new Memo();
			$memo->setMemo($data['message']);
			$memo->setProduct($product);
			$em->persist($memo);
			$em->flush();
			$id = $memo->getId();
			$memo = $em->getRepository('\Kasjroet\Entity\Memo')->find($id);
			$aMemo = array();
			$aMemo['id'] = $memo->getId();
			$aMemo['message'] = $memo->getMemo();
			return $this->getResponse()->setContent(Json::encode($aMemo));
		}

	}
}