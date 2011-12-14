<?php

Yii::import('zii.widgets.CPortlet');

class RecentComments extends CPortlet
{
	public $title='Recent Comments';
	public $maxComments=10;

	public function getRecentComments()
	{
		return PublicationsComment::model()->findRecentComments($this->maxComments);
	}

	protected function renderContent()
	{
		$this->render('recentComments');
	}
}