<?php

return CMap::mergeArray(
    require_once(dirname(__FILE__) . '/main.php'), array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        
        'defaultController' => 'main/admin/index',
        // стандартный контроллер
        //'defaultController' => 'posts',
        // компоненты
        'components' => array(
            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'main/error',

            ),
            // пользователь
            'user' => array(
                'loginUrl' => array('/user/login'),
            ), 
            // mailer
            /*'mailer' => array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),*/
        ),
    )
);
