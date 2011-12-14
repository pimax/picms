<?php

class Publications
{
    public static function t($message, $params = array(), $source = null, $language = null)
	{
		return Yii::t('PublicationsModule.messages', $message, $params, $source, $language);
	}
}