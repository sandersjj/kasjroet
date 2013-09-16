<?php

namespace KasjroetTest;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AbstractEntityRepositoryFactory implements AbstractFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $objectManager = $serviceLocator->get('Kasjroet\ObjectManager');

        if (! $serviceLocator instanceof ObjectManager) {
            throw new \BadMethodCallException('Service "MyModule\ObjectManager" is not an ObjectManager');
        }

        return ! $objectManager->getMetadataFactory()->isTransient($requestedName);
    }

    /**
     * {@inheritDoc}
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (! $this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
            throw new \BadMethodCallException('This abstract factory can\'t create service "' . $requestedName . '"');
        }

        return $serviceLocator->get('Kasjroet\ObjectManager')->getRepository($requestedName);
    }
}