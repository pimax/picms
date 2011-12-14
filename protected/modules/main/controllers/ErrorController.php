<?php

class ErrorController extends BackEndController
{
    public $layout = "//layouts/column1";
    
    public function filters()
    {
        return array();
    }
    
    public function actionIndex()
	{
		if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}