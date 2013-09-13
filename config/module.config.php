<?php

namespace Kasjroet;

return array(
    'controllers' => array(
        'invokables' => array(
            'Kasjroet\Controller\ProductsRest' => 'Kasjroet\Controller\ProductsRestController',
            'Kasjroet\Controller\Brands' => 'Kasjroet\Controller\BrandsController',
            'Kasjroet\Controller\Overview' => 'Kasjroet\Controller\OverviewController',
            'Kasjroet\Controller\ProductGroups' => 'Kasjroet\Controller\ProductGroupsController',
            
        ),
    ),
   /*'view_manager'  => array(
     'strategies' => array(
         'ViewJsonStrategy',
     ),
       'template_path_stack' => array(
         'kasjroet' =>   __DIR__ . '/../view',
       ),
   ),*/
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'options' => array(
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'Overview',
                        'action'    => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product' => array(
                        'type'  => 'Segment',
                        'options' => array(
                            'route' => '/product[/action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+ '
                            ),
                            'defaults' => array(
                                'controller' => 'Kasjroet\Controller',
                                'action' => 'index',
                            )
                        ),
                    ),
                ),
            ),
            'kasjroet' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/productgroup',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller'
                        ,'controller' => 'ProductGroups'
                        ,'action'    => 'index'
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
            'products'  => array(
                'type'      => 'Segment',
                'options'   => array(
                    'route' => '/products[/:id]',
                    'defaults' => array(
                      '__NAMESPACE__'   => 'Kasjroet\Controller',
                      'controller'      => 'productsRest'
                    ),
                    
                ),
            ),
            'overview'  => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/overview[/productgroup/:productgroup]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'Overview',
                        'action'    => 'index',
                    ),
                ),
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
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'kasjroet_form_extra' => array(
      array(
        'name'  => 'send',
          'attributes' => array(
              'type' => 'submit',
              'value' => 'Submit',
          ),
      ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/fromtend' => __DIR__ . '/../view/layout/frontend.phtml'
            // 'index/index'   => __DIR__ . '/../view/index/index.phtml',
           // 'error/404'     => __DIR__ . '/../view/error/404.phtml',
           // 'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view'
            ,'kasjroet' =>__DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'service_manager' => array(
      'factories'  => array(
          'ProductHydrator' => function($sm)
          {
              return new Util\Hydrator\Product(
                    new Util\Hydrator\ProductGroups(new Util\Hydrator\ProductGroup()),
                    new Util\Hydrator\Brand(),
                    new Util\Hydrator\Hechsheriem(new Util\Hydrator\Hechsher())

              );
          }
      ),
      'invokables' => array(),
    ),


);