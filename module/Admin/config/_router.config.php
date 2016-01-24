<?php

return array(
    'routes' => array(

        //Route Admin
        'admin' => array(
            'type'    => 'Literal',
            'options' => array(
                'route'    => '/admin',
                'defaults' => array(
                    'controller'    => 'dashboardController',
                    'action'        => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(

                //Route Articles
                'articles' => array(
                    'type'    => 'Segment',
                    'options' => array(
                        'route'    => '/articles[/:action]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                        'defaults' => array(
                            'controller'    => 'articleController',
                            'action'        => 'index',
                        ),
                    ),
                ),

                //Route Category
                'categories' => array(
                    'type'    => 'Segment',
                    'options' => array(
                        'route'    => '/categories[/:action]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                        'defaults' => array(
                            'controller'    => 'categoryController',
                            'action'        => 'index',
                        ),
                    ),
                )
            )
        ),

    ),
);