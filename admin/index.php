<?php

$yii = dirname(__FILE__).'/../../yii/framework/yii.php';
$config = dirname(__FILE__).'/../protected/config/backend.php';
 
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 0);
 

require_once($yii);
Yii::createWebApplication($config)->runEnd('backend');