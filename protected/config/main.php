<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$settings = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'test cms',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'defaultController'=>'site',
        
        'modules'=>require(dirname(__FILE__).'/__modules.php'),
        
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'db'=>array(
			'connectionString'=>'mysql:host=localhost;dbname=testing;',
			'username'=>'root',
			'password'=>'',
			'charset'=>'utf8',
                        'enableParamLogging' => true,
			'enableProfiling'=>true,
		),
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
			'errorAction'=>'index/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>require(dirname(__FILE__).'/__rules.php'),
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
/*
$settings['components']['db'] = array(
  'connectionString'=>'mysql:host=localhost;dbname=testing;',
  'username'=>'root',
  'password'=>'',
  'charset'=>'utf8',
// turn on schema caching to improve performance
//   'schemaCachingDuration'=> 60,
//   'enableProfiling'=>true,
//   'enableParamLogging' => true,
);

$settings['components']['log']['routes'][] = array(
    'class'=>'CProfileLogRoute',
    'levels'=>'error, warning, profile',
    'showInFireBug' => true,
    'report' => 'callstack',
    'ignoreAjaxInFireBug' => false
);
*/

require_once($settings['basePath'].'/globals.php');

return $settings;