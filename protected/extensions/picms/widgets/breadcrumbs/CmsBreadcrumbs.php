<?php

Yii::import('zii.widgets.CBreadcrumbs');

class CmsBreadcrumbs extends CBreadcrumbs
{
    public $htmlOptions = array('class' => 'breadcrumb');
    public function run()
	{
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=CHtml::openTag('li').CHtml::link(Yii::t('zii','Home'), Yii::app()->homeUrl).'<span class="divider">/</span>'.CHtml::closeTag('li');//CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
		else if($this->homeLink!==false)
			$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=CHtml::openTag('li').CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url).'<span class="divider">/</span>'.CHtml::closeTag('li');
			else
				$links[]=CHtml::openTag('li', array('class' => 'no-hover')).($this->encodeLabel ? CHtml::encode($url) : $url).CHtml::closeTag('li');
		}
		echo implode("",$links);
		echo CHtml::closeTag($this->tagName);
	}
}