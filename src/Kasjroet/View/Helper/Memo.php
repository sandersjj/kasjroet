<?php
namespace Kasjroet\View\Helper;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class Memo extends AbstractHelper
{
    protected $serviceLocator;
    protected $entityManager;

    public function __invoke(){
       $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
        $memo = new \Kasjroet\Entity\Memo();
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($memo);
        $config = $this->serviceLocator->get('config');
       if (isset($config['kasjroet_form_extra'])) {
            foreach ($config['kasjroet_form_extra'] as $field) {
                $form->add($field);
            }
       }

       $form->setHydrator(new DoctrineHydrator($em, '\Kasjroet\Entity\Memo'));
       return new ViewModel(array('form' => $form));
    }

    public function setEntityManager($em){
        $this->entityManager = $em;
    }

    public function setServiceLocator(ServiceManager $serviceLocator){
        $this->serviceLocator = $serviceLocator;
    }
}