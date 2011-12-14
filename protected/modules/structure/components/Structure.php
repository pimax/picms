<?php

class Structure
{
    public static function t($message, $params = array(), $source = null, $language = null)
	{
		return Yii::t('StructureModule.messages', $message, $params, $source, $language);
	}
}