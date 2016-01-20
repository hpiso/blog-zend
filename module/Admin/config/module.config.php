<?php

return array(
    //Controller config
    'controllers' => array(
        'invokables' => array(
            'dashboardController' => 'Admin\Controller\DashboardController',
            'articleController'   => 'Admin\Controller\ArticleController',
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
                        'controller'    => 'dashboardController',
                        'action'        => 'index',
                    ),
                ),
            ),

            'articles' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/articles[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller'    => 'articleController',
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
            'admin/layout-login'     => __DIR__ . '/../view/layout/layout-login.phtml',
            'admin/global-css'       => __DIR__ . '/../view/layout/partials/global-css.phtml',
            'admin/global-js'        => __DIR__ . '/../view/layout/partials/global-js.phtml',
        ),
        'template_path_stack' => array(
            'admin'    => __DIR__ . '/../view',
            'zfc-user' => __DIR__ . '/../view',
        ),
    ),
);