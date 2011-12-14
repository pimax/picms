<?php

class CmsDataGridButton extends CWidget
{
    public $title = '';
    
    public $url = '';
    
    public $htmlOptions = array('class' => 'btn success');
    
    public function run()
    {
        $this->htmlOptions['onclick'] = "location.href = '".Yii::app()->createUrl($this->url[0])."'";
        echo CHtml::button($this->title, $this->htmlOptions);
    }
    
}