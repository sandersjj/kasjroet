<?php


namespace KasjroetTest\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package KasjroetTest\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="kasjroet_product_group")
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