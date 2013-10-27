<?php

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="memo")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 */

class Memo {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column 
     */
    protected $memo;

    /**
     * @ORM\ManyToOne(targetEntity="Kasjroet\Entity\Product", inversedBy="memos")
     * @ORM\JoinColumn(name="productID", referencedColumnName="id")
     */
    protected $product;

	/**
	 * @ORM\Column(type="datetime") */
	protected $created;


	public function __construct(){
		$this->created = new \DateTime();
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return mixed
	 */
	public function getCreated()
	{
		return $this->created;
	}

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * @return mixed
     */
    public function getMemo()
    {
        return $this->memo;
    }

	/**
	 * @param mixed $product
	 */
	public function setProduct($product)
	{
		$this->product = $product;
	}

	/**
	 * @return mixed
	 */
	public function getProduct()
	{
		return $this->product;
	}



}