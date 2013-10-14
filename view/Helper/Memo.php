<?php
namespace Kasjroet\View\Helper;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\View\Helper\AbstractHelper;



class Memo extends AbstractHelper
{
    protected $serviceLocator;
    protected $entityManager;

    public function __invoke(){
       $memo = $this->entityManager->get('Product\Entity\Memo');
       $builder = new AnnotationBuilder($this->entityManager);
       $form = $builder->createForm($memo);
       return new View(array('form' => $form));
    }

    public function setEntityManager($em){
        $this->entityManager = $em;
    }
}