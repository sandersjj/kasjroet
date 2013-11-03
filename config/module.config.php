<?php

namespace Kasjroet;

return array(
    'controllers' => array(
        'invokables' => array(
            'Kasjroet\Controller\ProductsRest' 	=> 'Kasjroet\Controller\ProductsRestController',
            'Kasjroet\Controller\Brands' 		=> 'Kasjroet\Controller\BrandsController',
            'Kasjroet\Controller\Overview' 		=> 'Kasjroet\Controller\OverviewController',
            'Kasjroet\Controller\ProductGroups' => 'Kasjroet\Controller\ProductGroupsController',
            'Kasjroet\Controller\Products' 		=> 'Kasjroet\Controller\ProductsController',
			'Kasjroet\Controller\Memo' 			=> 'Kasjroet\Controller\MemoController',
        ),
        'abstract_factories' => array(
            'Kasjroet\AbstractEntityControllerFactory' => 'Kasjroet\AbstractEntityControllerFactory',
        ),
    ),
    'entity_controllers' => array(
        'Products' => 'Kasjroet\Controller\ProductsController',
        'Overview' => 'Kasjroet\Controller\OverviewController'
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'Overview',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/products[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Kasjroet\Controller',
                                'controller' => 'Products',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'memo' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/memos[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Kasjroet\Controller',
                                'controller' => 'Memo',
                                'action' => 'index',
                            ),
                        ),

                    )
                ),
            ),
            'kasjroet' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/productgroup',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller'
                    , 'controller' => 'ProductGroups'
                    , 'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'client' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/client[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Client',
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
            'products' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/products[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'productsRest'
                    ),

                ),
            ),
            'overview' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/overview[/productgroup/:productgroup]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'Overview',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
// Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
			'zfcuser_entity' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'kasjroet_form_extra' => array(
        array(
            'name' => 'send',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/frontend' => __DIR__ . '/../view/layout/frontend.phtml'
            // 'index/index'   => __DIR__ . '/../view/index/index.phtml',
            // 'error/404'     => __DIR__ . '/../view/error/404.phtml',
            // 'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view'
            ,'kasjroet' => __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'service_manager' => array(

        'factories' => array(
            'ProductHydrator' => function ($sm) {
                return new Util\Hydrator\Product(
                    new Util\Hydrator\ProductGroups(new Util\Hydrator\ProductGroup()),
                    new Util\Hydrator\Brand(),
                    new Util\Hydrator\Hechsheriem(new Util\Hydrator\Hechsher())

                );
            }
        ),
/*        'abstract_factories' => array(
            'Kasjroet\AbstractEntityControllerFactory' => 'Kasjroet\AbstractEntityControllerFactory',
        )*/
    ),
	'zfcuser' => array(
		'user_entity_class'       => 'Kasjroet\Entity\User',
		'enable_default_entities' => false,
		'enable_username'		=> true,
		'enable_display_name'	=> true,
		'enable_user_state' 	=> true,
		'default_user_state' 	=> 1

	),


);