<?php
namespace KasjroetTest\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Product
 * @package KasjroetTest\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="kasjroet_product")
 */
class Product {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")

     */
    protected $id;

    /**
     *  brandId -> bolletje, John West
     *  @ORM\ManyToOne(targetEntity="Brand", inversedBy="products")
     */
    protected $brand;

    /**
     * productGroupId -> Vis / Groente / Vlees enz.
     * @ORM\ManyToMany(targetEntity="productGroup")
     */
    protected $productGroups;

    /**
     * productName -> Gerookte zalm
     * @ORM\Column(nullable=false)
     */
    protected $productName;

    /**
     * description -> Only kosher if Xyz.
     * @ORM\Column
     */
    protected $description;

    /**
     * hechsheriem -> Multiple hechsherim should be possible
     * @ORM\ManyToMany(targetEntity="hechsher")
     */
    protected $hechsheriem;

    /**
     *
     * @ORM\Column(type="boolean")
     */
    protected $visible;

    /**
     * memos -> this is only for backend.
     * @ORM\ManyToMany(targetEntity="\Kasjroet\Entity\Memo")
     */
    protected $memos;

    public function __construct() {
        $this->memos = new ArrayCollection();
        $this->hechsheriem = new ArrayCollection();
        $this->productGroups = new ArrayCollection();

    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }


    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function getMemos() {
        return $this->memos;
    }

    public function setMemos($memos) {
        $this->memos = $memos;
    }

    public function addHechsher(Hechsher $hechsher){
        if (!$this->hechsheriem->contains($hechsher)){
            $this->hechsheriem  ->add($hechsher);
        }
    }

    /**
     * Returns all related product groups
     * @return ArrayCollection
     */
    public function getProductGroups() {
        return $this->productGroups;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $productGroups
     */
    public function setProductGroups(\Doctrine\Common\Collections\ArrayCollection $productGroups) {
        $this->productGroups = $productGroups;
    }

    /**
     * This function unsets a product group
     */
    public function unsetProductsGroups() {
        unset($this->productGroups);
    }


    /**
     * Returns all related product groups
     * @return ArrayCollection
     */
    public function getHechsheriem() {
        return $this->hechsheriem;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $hechsheriem
     */
    public function setHechsheriem(\Doctrine\Common\Collections\ArrayCollection $hechsheriem) {
        $this->hechsheriem = $hechsheriem;
    }

    /**
     * This function unsets hechsherim
     */
    public function unsetHechsheriem() {
        unset($this->hechsheriem);
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}