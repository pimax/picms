<?php

class autoSuggest extends CInputWidget
{
    public $textArea = false;
    
    public $data;
    
    public $url = '';
    
    public $minChars = 1;

	public $options=array();
    
    protected $baseUrl;	
    
    public function init()
	{
        list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		$this->initJs();

		if($this->hasModel())
		{
			$field=$this->textArea ? 'activeTextArea' : 'activeTextField';
			echo CHtml::$field($this->model,$this->attribute,$this->htmlOptions);
		}
		else
		{
			$field=$this->textArea ? 'textArea' : 'textField';
			echo CHtml::$field($name,$this->value,$this->htmlOptions);
		}
    }
    
    public function initJs()
	{
        $id = $this->htmlOptions['id'];
        
        $options = CJavaScript::encode(array('minChars' => $this->minChars, 'preFill' => $this->model["attributes"][$this->attribute]));
        
        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;                       
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $ClientScript = Yii::app()->getClientScript();        
        $ClientScript->registerCoreScript('jquery');
        $ClientScript->registerScriptFile($this->baseUrl. "/js/jquery.autoSuggest.js");
        $ClientScript->registerCssFile($this->baseUrl."/css/autoSuggest.css");
        
		if($this->data!==null)
			$data=CJavaScript::encode($this->data);
		else
		{
			$url=CHtml::normalizeUrl($this->url);
			$data='"'.$url.'"';
		}
		$ClientScript->registerScript('autoSuggest#'.$id, "jQuery(\"#{$id}\").autoSuggest($data, {$options});");
    }
}