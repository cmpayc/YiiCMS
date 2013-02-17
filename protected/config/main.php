<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$settings = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YiiCMS',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'defaultController'=>'site',
        
        'modules'=>json_decode(file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules.json'), true),
        
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'db'=>require(dirname(__FILE__).DIRECTORY_SEPARATOR.'__connect.php'),
                'session' => array(
                        'class' => 'CDbHttpSession',
                        'cookieParams' => array(
                           'domain' => '',
                           'lifetime' => 60*60*24*14, //2 недели
                        ),
                        'timeout' => 60*60*24*14, //2 недели
                        'autoCreateSessionTable' => true,
                        'connectionID' => 'db',
                        'gCProbability' => 1,
                ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>json_decode(file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'rules.json'), true)
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
            'salt'=>'test'
        ),
);
//Выбор языка
$settings['language'] ='ru';

require_once($settings['basePath'].DIRECTORY_SEPARATOR.'globals.php');

return $settings;