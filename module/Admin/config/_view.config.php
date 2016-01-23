<?php

return array(
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
);