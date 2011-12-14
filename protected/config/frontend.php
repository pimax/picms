<?php

return CMap::mergeArray(
    require_once(dirname(__FILE__) . '/main.php'), array(
        // стандартный контроллер
        'defaultController' => '/',
        // компоненты
        'components' => array(
            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'site/error',

            ),
            
            'mailer' => array(
                'class' => 'application.extensions.mailer.EMailer',
                'pathViews' => 'application.views.email',
                'pathLayouts' => 'application.views.email.layouts'
            ),
            
            // пользователь
            /*'user' => array(
                'loginUrl' => array('/users/login'),
            ),*/
            // mailer
            /*'mailer' => array(
                'pathViews' => 'application.views.backend.email',
                'pathLayouts' => 'application.views.email.backend.layouts'
            ),*/
        ),
    )
);
