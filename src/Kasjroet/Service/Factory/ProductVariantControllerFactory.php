<?php
/**
 * Created by PhpStorm.
 * User: jigal
 * Date: 5/16/14
 * Time: 1:15 PM
 */

namespace Kasjroet\Service\Factory;

use Kasjroet\Controller\ProductVariantController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ProductVariantControllerFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $controllers)
	{
		$pvService = $controllers->getServiceLocator()->get('product-variant-service');
		$controller = new ProductVariantController();
		$controller->setProductVariantService($pvService);
		return $controller;
	}
} 