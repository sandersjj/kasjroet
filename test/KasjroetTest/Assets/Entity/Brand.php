<?php
namespace KasjroetTest\Assets\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package KasjroetTest\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="kasjroet_brand")
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

    /**
     * Gets the brand ID
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the brand Id
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the brandName
     * @return mixed
     */
    public function getBrandName() {
        return $this->brandName;
    }

    /**
     * Sets the brandName
     * @param $brandName
     */
    public function setBrandName($brandName) {
        $this->brandName = $brandName;
    }

    public function __toString() {
        return $this->brandName;
    }

}