<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).'/'.'..',
	'name'=>'picms',
    'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',
        'ext.debugtoolbar.*',
        'ext.picms.*',
        'ext.picms.widgets.*',
        'ext.picms.widgets.datagrid.*',
        'ext.giix-components.*', // giix components
        
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.services.*',
        
        'ext.CJuiDateTimePicker.CJuiDateTimePicker'
        
        
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
        
		'gii'=>array(
			'class' => 'system.gii.GiiModule',
            'generatorPaths' => array(
                'ext.giix-core', // giix generators
            ),
			'password'=>'CAQskigR',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
        
        'user' => array(
            'tableUsers' => 'user_users',
            'tableProfiles' => 'user_profiles',
            'tableProfileFields' => 'user_profiles_fields',
        ),
        
        'users',
        
        'rights' => array(
            'debug'=>true,
			'enableBizRuleData'=>true,            
        ),
        
        'publications' => array(
            'commentNeedApproval' => false
        ),
        
        'structure',        
        'main',
        'forms',
        'tools',
        'search'
		
	),
    
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.behaviors.WebApplicationEndBehavior',
        ),
    ),

	// application components
	'components'=>array(
        'simpleImage'=>array(
            'class' => 'application.extensions.simpleImage.CSimpleImage',
        ),
		'user'=>array(
            'class' => 'RWebUser',
            'allowAutoLogin'=>true,
        ),
        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles' => array('Guest'), // дефолтная роль
            'itemTable'=>'rights_authitem',
			'itemChildTable'=>'rights_authitemchild',
			'assignmentTable'=>'rights_authassignment',
			'rightsTable'=>'rights_rights',
        ),
        
        'assetManager'=>array(
            'baseUrl'=> 'http://'.$_SERVER['SERVER_NAME'].'/static/assets',
            'basePath'=> $_SERVER['DOCUMENT_ROOT'].'/static/assets',
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
            'urlSuffix' => '',
            'showScriptName' => false,
			'rules'=>array(
                'user/connect/<service:(vkontakte|facebook)>' => 'user/connect',
                'user/disconnect/<service:(vkontakte|facebook)>' => 'user/disconnect',
                'user/login/<service:(vkontakte|facebook)>' => 'user/login',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',                
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dev_fashiondb',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),		  
        
		'request'=>array(
			//'enableCsrfValidation'=>true,
		),
        'format' => array(
            'dateFormat' => 'd.m.Y',
            'timeFormat' => 'H:i:s',
            'datetimeFormat' => 'd.m.Y H:i:s'
        ),
        
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// debug toolbar configuration
				array(
					'class'=>'XWebDebugRouter',
					'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('127.0.0.1'),
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
        ),
        
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => array( // You can change the providers and their classes.
                'facebook' => array(
                    'class' => 'FacebookOAuthService',
                    'client_id' => '199678970104808',
                    'client_secret' => '2c7295ce0c65d25950691cb6705c47e8',
                ),
                'vkontakte' => array(
                    'class' => 'VKontakteOAuthService',
                    'client_id' => '2634817',
                    'client_secret' => 'aPk4f39n2TJldUwNtbuc',
                ),
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params'=>require(dirname(__FILE__).'/params.php')
);