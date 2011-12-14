<?php

class MapController extends FrontEndController
{
    public function allowedActions()
	{
	 	return 'index, map';
    }
    
	public function actionIndex()
	{
        if(!empty($_GET['path'])) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {           
            $this->actionMap();
        }
	}
    
    public function actionMap()
    {
        Yii::import('application.modules.structure.models.*');
        Yii::import('application.modules.publications.models.*');
        
        $aPages = Page::model()->findAll(array('condition' => 't.show_in_sitemap = 1', 'order'=>'lft'));
        $aPublications = PublicationsCategory::model()->findAll(array('order' => 'title'));
        
        $nCount = count($aPublications);
        $nColCount = ceil($nCount / 2);
        $publications1 = array(); $publications2 = array();
        for ($i = $nColCount * (1 - 1); $i <= $nColCount * 1 - 1; $i++) {
            $publications1[] = $aPublications[$i];
        }
        
        for ($i = $nColCount * (2 - 1); $i <= $nColCount * 2 - 1; $i++) {
            $publications2[] = $aPublications[$i];
        }
        
        
		$this->render('index', array(
            'pages' => $aPages,
            'publications1' => $publications1,
            'publications2' => $publications2
        ));
    }
}