<?php

return array(
    //Controller config
    'controllers' => array(
        'factories' => array(
            'Blog\Controller\Index' => 'Blog\Factory\IndexControllerFactory',
        ),
    ),

    //Routing config
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),

    //View config
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml'
        ),
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);