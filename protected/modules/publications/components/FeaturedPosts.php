<?php

class FeaturedPosts extends CWidget
{
    public function init()
    {
        Yii::import('application.modules.publications.models.*');
    }

	public function getFeaturedPosts()
	{
		return PublicationsPost::model()->featured()->findAll();
	}

	public function run()
	{
		$this->render('featuredPosts');
	}
}