<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 4/29/14
 * Time: 6:27 PM
 */

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductVariant
 * @package Kasjroet\Entity
 * @ORM\Entity
 * @ORM\Table(name="productVariant")
 */
class ProductVariant
{
	/**
	 * @ORM\id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Kasjroet\Entity\Product", inversedBy="productVariants")
	 */
	protected $productId;

	/**
	 * Name like: Vanille smaak
	 * @ORM\Column(nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(nullable=false)
	 */
	protected $description;

	/**
	 * tags like: Melkkost, Parve, vegetarisch enz..
	 * @ORM\ManyToMany(targetEntity="tag")
	 */
	protected $tags;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $visible;

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
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
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $tags
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;
	}

	/**
	 * @return mixed
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param mixed $visible
	 */
	public function setVisible($visible)
	{
		$this->visible = $visible;
	}

	/**
	 * @return mixed
	 */
	public function getVisible()
	{
		return $this->visible;
	}




} 