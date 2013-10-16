<?php
namespace Kasjroet\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class MemoController extends AbstractKasjroetActionController
{
    public function memoAction(){
        $em = $this->getEntityManager();

        $Memo = new \Kasjroet\Entity\Memo;
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
}