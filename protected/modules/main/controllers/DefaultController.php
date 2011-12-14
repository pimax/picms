<?php

class DefaultController extends BackEndController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}