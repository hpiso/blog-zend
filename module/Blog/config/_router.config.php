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

        //Route Contact
        'contact' => array(
            'type'    => 'Literal',
            'options' => array(
                'route'    => '/contact',
                'defaults' => array(
                    'controller'    => 'blogController',
                    'action'        => 'contact',
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

        //Route filter caterory
        'category' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/category[/:slug]',
                'constraints' => array(
                    'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                ),
                'defaults' => array(
                    'controller'    => 'blogController',
                    'action'        => 'category',
                ),
            ),
        ),
    ),
);