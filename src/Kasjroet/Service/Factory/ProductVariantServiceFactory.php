<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 5/16/14
 * Time: 6:16 PM
 */

namespace Kasjroet\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Kasjroet\Service\ProductVariantService;


class ProductVariantServiceFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $services)
	{

		$objectManager = $services->get('Doctrine\ORM\EntityManager');
		$productVariantService = new ProductVariantService();
		$productVariantService->setObjectManager($objectManager);
		return $productVariantService;
	}
}