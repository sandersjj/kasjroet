<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 5/13/14
 * Time: 8:42 PM
 */

namespace Kasjroet\Service;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class ProductVariantService implements ObjectManagerAwareInterface
{
	private $objectManager;
	protected $entity = '\Kasjroet\Entity\ProductVariant';

	/**
	 * @param $id
	 * @return object
	 * @throws \InvalidArgumentException
	 */
	public function get($id)
	{
		if(!is_numeric($id) || $id <= 0 )
		{
			throw new \InvalidArgumentException(sprintf('%s is not a valid id', $id));
		}

		return $this->getObjectManager()->getRepository($this->entity)->find($id);
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