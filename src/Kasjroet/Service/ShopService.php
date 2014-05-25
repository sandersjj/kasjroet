<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 5/11/14
 * Time: 5:50 PM
 */

namespace Kasjroet\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;

class ShopService implements ObjectManagerAwareInterface

{

	/**
	 * @var
	 */

	private $objectManager;
	private $entity  = '\Kasjroet\Entity\Shop';


	/**
	 * @param $id
	 * @return object
	 * @throws \InvalidArgumentException
	 */
	public function get($id)
	{
		if(!is_int($id) || $id <= 0 )
		{
			throw new \InvalidArgumentException(sprintf('%s is not a valid id', $id));
		}

	  	return $this->getObjectManager()->getRepository($this->entity)->find($this->entity, $id);
	}

	/**
	 *
	 */
	public function save()
	{

	}

	/**
	 *
	 */
	public function delete()
	{

	}

	/**
	 *
	 */
	public function listShops()
	{

	}


	/**
	 * Set the object manager
	 *
	 * @param ObjectManager $objectManager
	 */
	public function setObjectManager(ObjectManager $objectManager)
	{
		$this->objectManager = $objectManager;
	}

	/**
	 * Get the object manager
	 *
	 * @return ObjectManager
	 */
	public function getObjectManager()
	{
		return $this->objectManager;
	}
}