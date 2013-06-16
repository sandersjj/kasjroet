<?php
namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;



/**
 * @ORM\Entity(repositoryClass="Kasjroet\EntityRepository\Product")
 * @ORM\Table(name="product")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 * @Annotation\Name("Product")
 */
class Product {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Attributes({"type":"hidden"})
     */
    protected $id;

    /**
     *  brandId -> bolletje, John West
     * 
     *  @ORM\ManyToOne(targetEntity="Brand", inversedBy="products")
     */
    protected $brand;

    /**
     * productGroupId -> Vis / Groente / Vlees enz.
     * @ORM\ManyToMany(targetEntity="productGroup")
     * @Annotation\Type("Zend\Form\Element\Select")
     
     */
    protected $productGroup;

    /**
     * productName -> Gerookte zalm
     * @ORM\Column(nullable=false)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Product name:"})
     */
    protected $productName;

    /**
     * description -> Only kosher if Xyz.
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Product description"})
     * @ORM\Column
     */
    protected $description;

    /**
     * hechsheriem -> Multiple hechsherim should be possible
     * @ORM\ManyToMany(targetEntity="\Kasjroet\Entity\Hechsher")
     */
    protected $hechsheriem;

    /**
     * visible -> default false
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
        $this->productGroup = new ArrayCollection();
          
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

    public function getProductGroup() {
        return $this->productGroup;
    }

    public function setProductGroup($productGroup) {
        $this->productGroup = $productGroup;
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

    public function getHechsheriem() {
        return $this->hechsheriem;
    }

    public function setHechsheriem($hechsheriem) {
        $this->hechsheriem = $hechsheriem;
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




}

