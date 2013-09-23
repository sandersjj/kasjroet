<?php

namespace Kasjroet;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Doctrine\Common\Persistence\ObjectManager;

class AbstractEntityControllerFactory  implements AbstractFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {

        if (! $serviceLocator instanceof AbstractPluginManager) {
            throw new \BadMethodCallException('This abstract factory is meant to be used only with a plugin manager');
        }

        $parentLocator = $serviceLocator->getServiceLocator();
        $config        = $parentLocator->get('config');

        return isset($config['entity_controllers'][$requestedName]);
    }

    /**
     * {@inheritDoc}
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (! $this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
            throw new \BadMethodCallException('This abstract factory can\'t create service "' . $requestedName . '"');
        }

        $parentLocator = $serviceLocator->getServiceLocator();
        $config        = $parentLocator->get('config');

        $entityName = $config['entity_controllers'][$requestedName];

        return new BaseEntityController($entityName);
    }
}