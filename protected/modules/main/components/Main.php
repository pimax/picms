<?php

class Main
{
    public static function t($message, $params = array(), $source = null, $language = null)
	{
		return Yii::t('MainModule.messages', $message, $params, $source, $language);
	}
}