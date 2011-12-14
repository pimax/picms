<?php
Yii::import('application.modules.rights.components.*');

class Controller extends RController
{

	public $layout = '';

	public $menu=array();

	public $breadcrumbs=array();  
    
    protected $sViewSuffix = '';
    
    public $pageMainHeader = '';
    public $pageMainHeaderDescription = '';
    
    public function init()
    {
        if (Yii::app() instanceof CmsApplication) {
            // front end
            
            if (Yii::app()->getPage() && Yii::app()->getPage()->template_id) {
                $this->layout = '//layouts/'.Yii::app()->getPage()->template->layout;
            } else {
                $this->layout = '//layouts/'.Yii::app()->getSite()->template->layout;
            }
        } else {
            // back end
            
            if (!$this->layout) {
                $this->layout = '//layouts/admin';
            }
            
            $this->sViewSuffix = '_admin';
        }
        
        parent::init();
    }
    
    public function render($view, $data = null, $return = false)
	{
        //echo $this->getModule()->getViewPath();
        parent::render($view.$this->sViewSuffix, $data, $return);
    }
}