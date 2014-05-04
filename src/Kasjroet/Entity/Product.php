<?php
namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;


use Kasjroet\Entity\Brand;




/**
 * @ORM\Entity(repositoryClass="Kasjroet\EntityRepository\Product")
 * @ORM\Table(name="product")
 */
class Product{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     *  brandId -> bolletje, John West
     *  @ORM\ManyToOne(targetEntity="Kasjroet\Entity\Brand")
     *  @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=false)
     */
    protected $brand;

    /**
     * productGroupId -> Vis / Groente / Vlees enz.
     * @ORM\ManyToMany(targetEntity="productGroup")
     */
    protected $productGroups;

	/**
	 * tags like: Melkkost, Parve, vegetarisch enz..
	 * @ORM\ManyToMany(targetEntity="tag")
	 */
	protected $tags;

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
	 * hechsheriem -> Multiple Shops should be possible
	 * @ORM\ManyToMany(targetEntity="Shop")
	 */
	protected $shops;

    /**
     *
     * @ORM\Column(type="boolean")
     */
    protected $visible;

    /**
     * memos -> this is only for backend.
     * @ORM\OneToMany(targetEntity="Kasjroet\Entity\Memo", mappedBy="product", cascade={"all"})
     */
    protected $memos;

    /**
     * 234@ORM\OneToMany(targetEntity="Kasjroet\Entity\Update", mappedBy="productID")
     */
    protected $update;

	/**
	 * @ORM\OneToMany(targetEntity="Kasjroet\Entity\ProductVariant", mappedBy="productId")
	 */
	protected $productVariants;

    public function __construct() {
        $this->memos = new ArrayCollection();
        $this->hechsheriem = new ArrayCollection();
        $this->productGroups = new ArrayCollection();
	    $this->productVariants = new ArrayCollection();
        $this->updates = new ArrayCollection();
        $this->shop = new ArrayCollection();
		$this->tags = new ArrayCollection();
    }

	/**
	 * @param mixed $productVariants
	 */
	public function setProductVariants($productVariants)
	{
		$this->productVariants = $productVariants;
	}

	/**
	 * @return mixed
	 */
	public function getProductVariants()
	{
		return $this->productVariants;
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

        if(!$brand instanceof Brand){
            throw new \ClassNotFoundException('Not type of class Brand');
        }

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


    /**
     * Returns all related product groups
     * @return ArrayCollection
     */
    public function getProductGroups() {
        return $this->productGroups;
    }

    /**
     * Sets the product groups
     * @param ArrayCollection $productGroups
     */
    public function setProductGroups(ArrayCollection $productGroups)
	{
        $this->productGroups = $productGroups;
    }


	/**
	 * Returns all related product groups
	 * @return ArrayCollection
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Sets the product tags
	 * @param ArrayCollection $tags
	 */
	public function setTags(ArrayCollection $tags)
	{
		$this->productGroups = $tags;
	}


    /**
     * This function unsets a product group
     */
    public function unsetProductsGroups()
	{
        unset($this->productGroups);
    }


    /**
     * Returns all related product groups
     * @return ArrayCollection
     */
    public function getHechsheriem()
	{
        return $this->hechsheriem;
    }

    /**
     * @param ArrayCollection $hechsheriem
     */

    public function setHechsheriem(ArrayCollection $hechsheriem)
	{
        $this->hechsheriem = $hechsheriem;
    }


}

