<?php

class FrontEndController extends Controller
{
	
	public $layout = '//layouts/main';		
	
	public $menu = array();	
	
	public $breadcrumbs = array();
    
    public function init()
    {
        if (Yii::app()->getPage() && Yii::app()->getPage()->template_id) {
            $this->layout = '//layouts/'.Yii::app()->getPage()->template->layout;
        } else {
            $this->layout = '//layouts/'.Yii::app()->getSite()->template->layout;
        }    
	}
}