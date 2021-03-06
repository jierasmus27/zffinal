<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'BidSite\Controller\User' => 'BidSite\Controller\UserController',
            'item' => 'BidSite\Controller\ItemController',
        ),
    ),
    
    'service_manager' => array(
        'aliases' => array(
            'bidsite_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BidSite\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'user_c' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BidSite\Controller\User',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'item' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    'route' => '/item[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'item',
                        'action'     => 'index',
                     ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),                   
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
            'item' => __DIR__ . '/../view',
        ),
    ),
);