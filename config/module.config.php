<?php

namespace Kasjroet;

return array(
	'controllers' => array(
		'invokables' => array(
			'Kasjroet\Controller\ProductsRest' => 'Kasjroet\Controller\ProductsRestController',
			'Kasjroet\Controller\Brands' => 'Kasjroet\Controller\BrandsController',
			'Kasjroet\Controller\Overview' => 'Kasjroet\Controller\OverviewController',
			'Kasjroet\Controller\ProductGroups' => 'Kasjroet\Controller\ProductGroupsController',
			'Kasjroet\Controller\Products' => 'Kasjroet\Controller\ProductsController',
			'Kasjroet\Controller\Memo' => 'Kasjroet\Controller\MemoController',
			'Kasjroet\Controller\Index' => 'Kasjroet\Controller\IndexController',
			'Kasjroet\Controller\Shop' => 'Kasjroet\Controller\ShopController',
			//'Kasjroet\Controller\ProductVariant' => 'Kasjroet\Controller\ProductVariantController',
		),
		'abstract_factories' => array(
			'Kasjroet\AbstractEntityControllerFactory' => 'Kasjroet\AbstractEntityControllerFactory',
		),
		'factories' => array(
			'Kasjroet\Controller\ProductVariant' => 'Kasjroet\Service\Factory\ProductVariantControllerFactory'
		)
	),
	'entity_controllers' => array(
		'Products' => 'Kasjroet\Controller\ProductsController',
		'Overview' => 'Kasjroet\Controller\OverviewController'
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'__NAMESPACE__' => 'Kasjroet\Controller',
						'controller' => 'Index',
						'action' => 'index',
					),
				)
			),
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
					'brands' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/brands[/:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
								'__NAMESPACE' => 'Kasjroet\Controller',
								'controller' => 'Brands',
								'action' => 'index'
							)
						)
					),
					'products' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/products[/:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'__NAMESPACE' => 'Kasjroet\Controller',
								'controller' => 'Products',
								'action' => 'index'
							)
						)
					),
					'shop' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/shop[/:action]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Kasjroet\Controller',
								'controller' => 'Shop',
								'action' => 'index',
							),

						),
					),
					'productvariant' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/productvariant[/:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Kasjroet\Controller',
								'controller' => 'productvariant',
								'action' => 'showForm',
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
					'route' => '/',
					'defaults' => array(
						'__NAMESPACE__' => 'Kasjroet\Controller'
					,
						'controller' => 'index'
					,
						'action' => 'index'
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'productgroup' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/productgroup',
							'defaults' => array(
								'__NAMESPACE__' => 'Kasjroet\Controller'
							,
								'controller' => 'ProductGroups'
							,
								'action' => 'index'
							),
						),
					),
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
	'hydrators' => array(
		'invokables' => array('BrandHydrator' => 'Kasjroet\Util\Hydrator\Brand'),
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
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/frontend' => __DIR__ . '/../view/layout/frontend.phtml',
			'partial/modal' => __DIR__ . '/../view/partial/modal.phtml',
		),
		'template_path_stack' => array(
			'application' => __DIR__ . '/../view',
			'kasjroet' => __DIR__ . '/../view'
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
	'navigation' => array(
		'adminmenu' => array(
			array(
				'label' => 'Home',
				'route' => 'zfcadmin',
			),
			array(
				'label' => 'Products',
				'route' => 'zfcadmin/products',
			),
			array(
				'label' => 'Brands',
				'route' => 'zfcadmin/brands'
			),
		),
	),
	'service_manager' => array(
		'factories' => array(
			'admin_navigation' => 'Kasjroet\Navigation\Service\AdminNavigationFactory',
			'product-variant-service' => 'Kasjroet\Service\Factory\ProductVariantServiceFactory'
		),

	),
	'zfcuser' => array(
		'user_entity_class' => 'Kasjroet\Entity\User',
		'enable_default_entities' => false,
		'enable_username' => true,
		'enable_display_name' => true,
		'enable_user_state' => true,
		'default_user_state' => 1,
		'login_redirect_route' => "zfcadmin"

	),
	'view_helpers' => array(
		'invokables' => array(
			'modal' => 'Kasjroet\View\Helper\Modal'
		)
	),


);