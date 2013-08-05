<?php
namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="brand")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 * @Annotation\Name("Brand")
 */
class Brand {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     * 
     */
    protected $brandName;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brand")
     */
    protected $products;
    
    public function __construct() {
        $this->products = new ArrayCollection();
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBrandName() {
        return $this->brandName;
    }

    public function setBrandName($brandName) {
        $this->brandName = $brandName;
    }

    public function __toString() {
        return $this->brandName;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
