<?php

namespace Kasjroet;

return array(
    'controllers' => array(
        'invokables' => array(
            'Kasjroet\Controller\Products' => 'Kasjroet\Controller\ProductsController',
            'Kasjroet\Controller\Brands' => 'Kasjroet\Controller\BrandsController',
            'Kasjroet\Controller\Overview' => 'Kasjroet\Controller\OverviewController',
            
        ),
    ),
//    'view_manager' => array(
//        'template_path_stack' => array(
//            'user' => __DIR__ . '/../view',
//        ),
//    ),
   'view_manager'  => array(
     'strategies' => array(
         'ViewJsonStrategy',
     ),
       'template_path_stack' => array(
         'kasjroet' =>   __DIR__ . '/../view',
       ),
   ),
    'router' => array(
        'routes' => array(
            'kasjroet' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/brand',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Kasjroet\Controller',
                        'controller' => 'Brands',
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
                      'controller'      => 'products'  
                    ),
                    
                ),
            ),
            'overview'  => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/overview[/:action][/:id]',
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
//        'template_map' => array(
//            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
//            'index/index'   => __DIR__ . '/../view/index/index.phtml',
//            'error/404'     => __DIR__ . '/../view/error/404.phtml',
//            'error/index'   => __DIR__ . '/../view/error/index.phtml',
//        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

);