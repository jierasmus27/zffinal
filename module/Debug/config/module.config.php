<?php
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'timer' => 'Debug\Service\Factory\TimerAbstractFactory',
        ),
    ),
    
    'timers' => array(    
        'timer' => array(        
            'times_as_float' => true,    
        ),
        'timer_non_float' => array(        
            'times_as_float' => false,    
        )
    ),
    
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'debug' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '[/:controller][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Debug\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),           
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'debug' => __DIR__ . '/../view',
        ),
    ),
);