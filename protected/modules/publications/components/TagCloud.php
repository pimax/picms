<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
	public $title='Tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags=PublicationsTag::model()->findTagWeights($this->maxTags);

		foreach($tags as $tag=>$weight)
		{
			$link=CHtml::link(CHtml::encode($tag), Yii::app()->getPage()->path.'/tag/'.$tag.'/');
			echo CHtml::tag('span', array(
				'class'=>'tag',
				'style'=>"font-size:{$weight}pt",
			), $link)."\n";
		}
	}
}