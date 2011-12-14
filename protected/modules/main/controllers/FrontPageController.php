<?php

class FrontPageController extends FrontEndController
{
	public function actionIndex()
	{
        Yii::import('application.modules.publications.models.*');
        Yii::import('application.modules.user.models.*');
        
        $criteria=new CDbCriteria(array(
			'condition'=>'status='.PublicationsPost::STATUS_PUBLISHED,
			'order'=>'post_date DESC',
			'with'=>array('category', 'commentCount'),
            'limit' => Yii::app()->params['postsPerPage']
		));              

		$dataProvider=new CActiveDataProvider('PublicationsPost', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));
        
        
        $nLast = 0;
        $aData = $dataProvider->getData();
        if (count($aData)) {
            foreach ($aData as $dat) {
                if ($dat->update_time > $nLast) {
                    $nLast = $dat->update_time;
                } 
            }
            
            header("Last-Modified: ".gmdate("D, d M Y H:i:s", $nLast)." GMT");
        }
        
        
        
		$this->render('index', array(
            'publications' => $dataProvider,
            'users' => User::model()->last()->active()->findAll()
        ));
	}
}