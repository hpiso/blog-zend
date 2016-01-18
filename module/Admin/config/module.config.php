<?php

return array(
    //Controller config
    'controllers' => array(
        'invokables' => array(
            'adminController' => 'Admin\Controller\IndexController',
        ),
    ),

    //Routing config
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller'    => 'adminController',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),

    //View config
    'view_manager' => array(
        'template_map' => array(
            'admin/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
);