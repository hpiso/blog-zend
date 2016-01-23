<?php

return array(
    'routes' => array(

        //Route Admin
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

        //Route Article
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
);