<?php

class Forms 
{
    public static function t($message, $params = array(), $source = null, $language = null)
	{
		return Yii::t('FormsModule.messages', $message, $params, $source, $language);
	}
}