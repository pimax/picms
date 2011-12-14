<?php

class DefaultController extends FrontEndController
{
    protected $nPageSize = 10;
    
    public function allowedActions()
	{
	 	return 'index, search, searchPosts, searchUsers';
    }
    
	public function actionIndex()
	{
        if(!empty($_GET['path'])) {
            $aPath = explode("/", $_GET['path']);
            
            if (count($aPath) == 2 && mb_strpos($aPath[1], "page") === 0) {
                if ($aPath[0] == 'posts') {
                    $_GET['PublicationsPost_page'] = mb_substr($aPath[1], 4, mb_strlen($aPath[1], "utf8"), "utf8");
                } else if ($aPath[0] == 'users') {
                    $_GET['User_page'] = mb_substr($aPath[1], 4, mb_strlen($aPath[1], "utf8"), "utf8");
                }
                unset($aPath[1]);
            }
            
            if (count($aPath) == 1 && $aPath[0] == 'posts') {
                // search in posts
                $this->actionSearchPosts();                
                           
            } else if (count($aPath) == 1 && $aPath[0] == 'users') {
                // search in users
                $this->actionSearchUsers();
            } else {
                throw new CHttpException(404,'The requested page does not exist.');
            }
        } else {           
            $this->actionSearch();
        }		
	}
    
    public function actionSearch()
    {
        $sQuery = '';
        $aPosts = array();
        $nPosts = 0;
        $aUsers = array();
        $nUsers = 0;
        if (Yii::app()->request->isPostRequest) {
            $sQuery = isset($_POST['s']) ? trim($_POST['s']) : '';
            Yii::app()->session->add('search_query', $sQuery);
            
            Yii::import('application.modules.publications.models.*');
            Yii::import('application.modules.user.models.*');
            
            $aPosts = new CActiveDataProvider('PublicationsPost', array(
                'criteria'=>array(
                    'condition'=>"t.status=:status AND (t.title LIKE '%".$sQuery."%' OR t.content LIKE '%".$sQuery."%' OR category.title LIKE '%".$sQuery."%')",
                    'params' => array(':status' => PublicationsPost::STATUS_PUBLISHED),
                    'order'=>'t.rating DESC, t.post_date DESC',
                    'with'=>array('category'),
                    'limit' => $this->nPageSize
                ),
                'pagination'=>false,
            ));
            $nPosts = PublicationsPost::model()->searchPostsCount($sQuery);
            
            $aUsers = new CActiveDataProvider('User', array(
                'criteria'=>array(
                    'condition'=>"t.status=:status AND (t.username LIKE '%".$sQuery."%' OR t.email LIKE '%".$sQuery."%' OR profile.firstname LIKE '%".$sQuery."%' OR profile.lastname LIKE '%".$sQuery."%')",
                    'params' => array(':status' => User::STATUS_ACTIVE),
                    'order'=>'t.rating DESC',
                    'with'=>array('profile'),
                    'limit' => $this->nPageSize
                ),
                'pagination'=>false,
            ));
            $nUsers = User::model()->searchUsersCount($sQuery);
        } else {
            Yii::app()->session->remove('search_query');
        }
        
        $this->render('index',array(
            'query' => $sQuery,
            'posts' => $aPosts,
            'posts_count' => $nPosts,
            'users' => $aUsers,
            'users_count' => $nUsers,
            'page' => 'index'
        ));
    }
    
    public function actionSearchPosts()
    {
        $sQuery = '';
        $aPosts = array();
        $nPosts = 0;
        $aUsers = array();
        $nUsers = 0;
        
        $sQuery = Yii::app()->session->get('search_query');
        if ($sQuery) {
            Yii::import('application.modules.publications.models.*');

            $aPosts = new CActiveDataProvider('PublicationsPost', array(
                'criteria'=>array(
                    'condition'=>"t.status=:status AND (t.title LIKE '%".$sQuery."%' OR t.content LIKE '%".$sQuery."%' OR category.title LIKE '%".$sQuery."%')",
                    'params' => array(':status' => PublicationsPost::STATUS_PUBLISHED),
                    'order'=>'t.rating DESC, t.post_date DESC',
                    'with'=>array('category'),
                ),
                'pagination'=>array(
                    'pageSize' => $this->nPageSize
                ),
            ));
            $nPosts = PublicationsPost::model()->searchPostsCount($sQuery);
        }
            
        $this->render('index',array(
            'query' => $sQuery,
            'posts' =>  $aPosts,
            'posts_count' => $nPosts,
            'users' => $aUsers,
            'users_count' => $nUsers,
            'page' => 'detail_posts'
        ));
    }
    
    public function actionSearchUsers()
    {
        $sQuery = '';
        $aPosts = array();
        $nPosts = 0;
        $aUsers = array();
        $nUsers = 0;
        
        $sQuery = Yii::app()->session->get('search_query');
        if ($sQuery) {
            Yii::import('application.modules.user.models.*');

            $aUsers = new CActiveDataProvider('User', array(
                'criteria'=>array(
                    'condition'=>"t.status=:status AND (t.username LIKE '%".$sQuery."%' OR t.email LIKE '%".$sQuery."%' OR profile.firstname LIKE '%".$sQuery."%' OR profile.lastname LIKE '%".$sQuery."%')",
                    'params' => array(':status' => User::STATUS_ACTIVE),
                    'order'=>'t.rating DESC',
                    'with'=>array('profile'),
                ),
                'pagination'=>array(
                    'pageSize' => $this->nPageSize
                ),
            ));
            $nUsers = User::model()->searchUsersCount($sQuery);
        }
            
        $this->render('index',array(
            'query' => $sQuery,
            'posts' => $aPosts,
            'posts_count' => $nPosts,
            'users' => $aUsers,
            'users_count' => $nUsers,
            'page' => 'detail_users'
        ));
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
        
        if (isset($params['PublicationsPost_page'])) {
            $sUrl .= '/page'.$params['PublicationsPost_page'];
        } else if (isset($params['User_page'])) {
            $sUrl .= '/page'.$params['User_page'];
        }
        
		return $sUrl;
	}
}