<?php

class BestPosts extends CWidget
{
	public $maxPosts = 5;
    
    public function init()
    {
        Yii::import('application.modules.publications.models.*');
    }

	public function getBestPosts()
	{
		return PublicationsPost::model()->findBestPosts($this->maxPosts);
	}

	public function run()
	{
		$this->render('bestPosts');
	}
}