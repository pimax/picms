<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
    
    public function filters()
    {
        return array();
    }
    
    public function init()
    {
        if (!Yii::app() instanceof CmsApplication) {
            $this->layout = "//layouts/simple";
        }
        
        parent::init();
    }
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

}