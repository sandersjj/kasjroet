<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 11/5/13
 * Time: 9:26 AM
 */

namespace Kasjroet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ArraySerializable")
 **/

class Tag {

	/**
	 * @ORM\id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column
	 */
	protected $tag;

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
	 * @param mixed $tag
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;
	}

	/**
	 * @return mixed
	 */
	public function getTag()
	{
		return $this->tag;
	}
}