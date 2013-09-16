<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'KasjroetTest\Assets\Entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'paths' => array(__DIR__ . '/../src/Kasjroet/Entity')
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Kasjroet\Entity' => 'Kasjroet_driver',
                ),
            ),
        ),
//        'entity_resolver' => array(
//            'orm_default' => array(
//                'resolvers' => array(
//                    'KasjroetTest\Assets\Entity\TargetInterface'
//                    => 'KasjroetTest\Assets\Entity\TargetEntity',
//                ),
//            ),
//        ),
        'connection' => array(
            'orm_default' => array(
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'memory' => true,
                ),
            ),
        ),
    ),
);