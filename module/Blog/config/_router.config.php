<?php

return array(
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
                    'controller'    => 'blogController',
                    'action'        => 'index',
                ),
            ),
        ),
    ),
);