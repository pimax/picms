<?php

class DefaultController extends Controller
{
    protected $_model = null;
    
    public function filters()
    {
        return array(
            //'ajaxOnly + ratePost, rateComment'
        );
    }
    
    public function allowedActions()
	{
	 	return 'index, list, view';
    }	
    
	public function actionIndex()
	{
        if(!empty($_GET['path'])) {
            $aPath = explode("/", $_GET['path']);
            
            if (count($aPath) == 1) {
                // show user
                $this->actionView($aPath[0]);                
                           
            } else if (count($aPath) == 0) {
                // show all users
                $this->actionList();
            } else {
                throw new CHttpException(404,'The requested page does not exist.');
            }
            
        } else {
            // show all users            
            $this->actionList();
        }
	}
    
    public function actionList()
    {
        if(!empty($_GET['path'])) {
            $aPath = explode("/", $_GET['path']);
            
            if (count($aPath) == 1 && mb_strpos($aPath[0], "page") === 0) {
                $_GET['page'] = mb_substr($aPath[0], 4, mb_strlen($aPath[0], "utf8"), "utf8");
                unset($aPath[0]);
            }            
        }
        
        $oPagination = new CPagination();
        $oPagination->setPageSize(Yii::app()->controller->module->user_page_size);
        
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANED,
                'order' => 't.rating DESC',
                'with' => array('profile')
		    ),
				
			'pagination'=>$oPagination           
            
		));
        
        $nLast = 0;
        $aData = $dataProvider->getData();
        if (count($aData)) {
            foreach ($aData as $dat) {
                if ($dat->lastactivity > $nLast) {
                    $nLast = $dat->lastactivity;
                } 
            }
            
            header("Last-Modified: ".gmdate("D, d M Y H:i:s", $nLast)." GMT");
        }

		$this->render('list',array(
			'dataProvider'=>$dataProvider,
		));
    }
    
    public function actionView($sUserAlias)
	{
		$user = $this->loadModel($sUserAlias);
        
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", $user->lastactivity)." GMT");

		$this->render('view',array(
			'model'=>$user
		));
	}
    
    public function loadModel($sUserAlias)
	{
		if($this->_model===null)
		{
            $criteria=new CDbCriteria(array(
                'condition'=>"t.username='".$sUserAlias."' AND status=1",
                'with'=>'profile',
            ));
            
            $this->_model = User::model()->find($criteria);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
    
    public function createUrl($route,$params=array(),$ampersand='&')
	{        
        $sUrl = Yii::app()->getPage()->path;
        if (isset($params['path']) && mb_strpos($params['path'], "page") !== 0) {
            if (mb_strpos($params['path'], "/page") !== false) {
                $sUrl .= '/'.  mb_substr($params['path'], 0, mb_strpos($params['path'], "/page"), "utf8"); 
            } else {
                $sUrl .= '/'.$params['path'];
            }
            
            unset($params['path']);
        }
        
        if (isset($params['page'])) {
            $sUrl .= '/page'.$params['page'];
        }
        
		return $sUrl;
	}
}