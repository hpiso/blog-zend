<?php

return array(
    'routes' => array(

        //Route HomeBlog
        'blog' => array(
            'type'    => 'Literal',
            'options' => array(
                'route'    => '/',
                'defaults' => array(
                    'controller'    => 'blogController',
                    'action'        => 'index',
                ),
            ),
        ),

        //Route article show
        'article' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/article[/:slug]',
                'constraints' => array(
                    'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                ),
                'defaults' => array(
                    'controller'    => 'blogController',
                    'action'        => 'show',
                ),
            ),
        ),
    ),
);