<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
// При установке делать проверку на short_open_tag
if(!is_dir(dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime')){
    if(!is_writable(dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR)){
        die('Directory '.dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.' is not writable');
    }else{
        mkdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime');
    }
}else if(!is_writable(dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR)){
    die('Directory '.dirname(__FILE__).DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.' is not writable');
}
if(!is_dir(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets')){
    if(!is_writable(dirname(__FILE__).DIRECTORY_SEPARATOR)){
        die('Directory '.dirname(__FILE__).DIRECTORY_SEPARATOR.' is not writable');
    }else{
        mkdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
    }
}else if(!is_writable(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR)){
    die('Directory '.dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.' is not writable');
}
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-read-only_svn/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
