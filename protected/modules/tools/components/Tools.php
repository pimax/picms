<?php

class Tools
{
    public static function t($message, $params = array(), $source = null, $language = null)
	{
		return Yii::t('ToolsModule.messages', $message, $params, $source, $language);
	}
}