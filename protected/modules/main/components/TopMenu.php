<?php

class TopMenu extends CWidget
{
    protected $aAllCategories = false;
    
    public function init()
    {
        Yii::import('application.modules.publications.models.*');
    }

	public function getCategoriesCol($nCol)
	{
        if (!$this->aAllCategories) {
            $this->aAllCategories = PublicationsCategory::model()->findAll(array(
                'order'=>'t.title ASC'
            ));
        }
        
        $nCount = count($this->aAllCategories);
        $nColCount = ceil($nCount / 2);
        $aResult = array();
        for ($i = $nColCount * ($nCol - 1); $i <= $nColCount * $nCol - 1; $i++) {
            $aResult[] = $this->aAllCategories[$i];
        }
        
        
		return $aResult;
	}

	public function run()
	{
		$this->render('topMenu');
	}
    
    public function isItemActive($url)
	{
        if ($url == Yii::app()->getRequest()->getRequestUri()) {
            return true;
        }
        
        return false;
	}
}