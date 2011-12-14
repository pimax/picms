<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/
$yii = dirname(__FILE__).'/../yii/framework/yii.php';
$cms = dirname(__FILE__).'/protected/components/CmsApplication.php';
$config = dirname(__FILE__).'/protected/config/frontend.php';
 
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 0);
 
require_once($yii);
require_once($cms);
Yii::createApplication('CmsApplication', $config)->runEnd('frontend');