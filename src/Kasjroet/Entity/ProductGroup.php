<?php

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="productGroup")
 * @ORM\Entity(repositoryClass="Kasjroet\EntityRepository\ProductGroup")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 */
class ProductGroup {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Product Group:"})
     */
    protected $productGroupName;


    public function __toString(){
        return $this->productGroupName;
    }

    public function getId(){
        return $this->id;
    }

    public function getProductGroupName(){
        return $this->productGroupName;
    }
}

