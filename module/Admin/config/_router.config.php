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
                        'route'    => '/articles[/:action][/:id]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+'
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
                        'route'    => '/categories[/:action][/:id]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+'
                        ),
                        'defaults' => array(
                            'controller'    => 'categoryController',
                            'action'        => 'index',
                        ),
                    ),
                ),

                //Route Commentaire
                'comment' => array(
                    'type'    => 'Segment',
                    'options' => array(
                        'route'    => '/commentaires[/:action][/:id]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+'
                        ),
                        'defaults' => array(
                            'controller'    => 'commentController',
                            'action'        => 'index',
                        ),
                    ),
                ),

            )
        ),

    ),
);