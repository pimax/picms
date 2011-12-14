<?php

class OptionsController extends BackEndController
{
    public $layout = "//layouts/column1";
    
	public function actionIndex()
	{
		$this->render('index');
	}
}