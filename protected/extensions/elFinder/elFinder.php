<?php

class elFinder extends CWidget
{
    public $baseUrl;
    
    public $selector = 'elFinder';
    
    private $tagName = 'div';
    
    private $htmlOptions = array();
    
    public $lang = 'ru';
    
    public function init()
    {
        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;                       
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $ClientScript = Yii::app()->getClientScript();        
        $ClientScript->registerCoreScript('jquery');               
        $ClientScript->registerScriptFile($this->baseUrl. "/js/jquery-ui-1.8.13.custom.min.js");
        $ClientScript->registerCssFile($this->baseUrl."/css/smoothness/jquery-ui-1.8.13.custom.css");
        $ClientScript->registerCssFile($this->baseUrl."/css/elfinder.full.css");          
        $ClientScript->registerCssFile($this->baseUrl."/css/theme.css");          
        $ClientScript->registerScriptFile($this->baseUrl."/js/elfinder.min.js");

        if ( isset($this->lang) && $this->lang != 'en')
        {
            $ClientScript->registerScriptFile($this->baseUrl."/js/i18n/elfinder.$this->lang.js");
        }
        
        $this->htmlOptions = array('id' => $this->selector);
    }
    
    public function initJs()
    {
        $js = "$().ready(function() { \n";
        $js .= "var elf = $('#".$this->selector."').elfinder({\n";
        $js .= "lang: '".$this->lang."',\n";
        $js .= "url : '".$this->baseUrl."/php/connector.php',\n";
        $js .= "separator : '/',\n";
        $js .= "height : '550'\n";
        $js .= "}).elfinder('instance');\n";
        $js .= "});";

        Yii::app()->clientScript->registerScript("Yii.elFinder_.$this->selector.", $js, CClientScript::POS_BEGIN);
    }
    
    public function run()
    {
        $this->initJs();
        
        echo CHtml::openTag($this->tagName, $this->htmlOptions)."\n";
		echo CHtml::closeTag($this->tagName);
    }
}