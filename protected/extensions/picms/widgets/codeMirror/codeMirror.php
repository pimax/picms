<?php

class codeMirror extends CInputWidget
{
    public $name;
    
    public $value;
    
    public function init()
    {
        $baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');

		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assets.'/lib/codemirror.css');
		$cs->registerCssFile($assets.'/theme/default.css');
		$cs->registerScriptFile($assets.'/lib/codemirror.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/mode/xml/xml.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/mode/javascript/javascript.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/mode/css/css.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/mode/clike/clike.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/mode/php/php.js', CClientScript::POS_HEAD);
    }
    
    public function run()
    {
        $rand = md5(uniqid(rand(), true));
        
        $js = 'var editor = CodeMirror.fromTextArea(document.getElementById("'.$rand.'"), {'."\n";
        $js .= 'lineNumbers: true,'."\n";
        $js .= 'matchBrackets: true,'."\n";
        $js .= 'mode: "application/x-httpd-php",'."\n";
        $js .= 'indentUnit: 4,'."\n";
        $js .= 'indentWithTabs: true,'."\n";
        $js .= 'enterMode: "keep",'."\n";
        $js .= 'tabMode: "shift",'."\n";
        $js .= '});';
        
        Yii::app()->clientScript->registerScript("Yii.codeMirror_".$rand, $js, CClientScript::POS_READY);
        
        echo CHtml::textArea($this->name, $this->value, array('id' => $rand));
    }
}