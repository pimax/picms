<?php

class PublicationsPublicController extends FrontEndController
{   
    protected $_model = null;
    
    public function filters()
    {
        return array(
            'ajaxOnly + ratePost, rateComment'
        );
    }
    
    public function allowedActions()
	{
	 	return 'index, list, view, suggestTags';
    }	
    
	public function actionIndex()
	{
		if(!empty($_GET['path'])) {
            $aPath = explode("/", $_GET['path']);
            
            if (count($aPath) == 1 && mb_strpos($aPath[0], "page") === 0) {
                $_GET['page'] = mb_substr($aPath[0], 4, mb_strlen($aPath[0], "utf8"), "utf8");
                unset($aPath[0]);
            }
            
            if (count($aPath) == 2 && mb_strpos($aPath[1], "page") === 0) {
                $_GET['page'] = mb_substr($aPath[1], 4, mb_strlen($aPath[1], "utf8"), "utf8");
                unset($aPath[1]);
            }
            
            if (count($aPath) == 3 && mb_strpos($aPath[2], "page") === 0) {
                $_GET['page'] = mb_substr($aPath[2], 4, mb_strlen($aPath[2], "utf8"), "utf8");
                unset($aPath[2]);
            }
            if (count($aPath) == 2 && $aPath[0] != 'tag') {
                // show post
                $this->actionView($aPath[0], $aPath[1]);                
            } else if (count($aPath) == 2 && $aPath[0] == 'tag') {
                // show posts by tag
                $this->actionList(false, $aPath[1]);
            } else if(count($aPath) == 1 && $aPath[0] == 'rate') {
                // rate post
                $this->actionRatePost();
            } else if(count($aPath) == 1 && $aPath[0] == 'comment_rate') {
                // rate comment
                $this->actionRateComment();    
            } else if(count($aPath) == 1 && $aPath[0] != 'rate' && $aPath[0] != 'comment_rate') {
                
                //echo mb_strrpos($aPath[0], ".atom", null, "utf8");
                //echo mb_strlen($aPath[0], "utf8");
                
                if (mb_strrpos($aPath[0], ".atom", null, "utf8") !== false && mb_strrpos($aPath[0], ".atom", null, "utf8") == mb_strlen($aPath[0], "utf8") - 5) {
                    $sCategoryPath = mb_substr($aPath[0], 0, mb_strrpos($aPath[0], ".atom", null, "utf8"), "utf8");
                    // show posts by category in Atom format
                    $this->actionListAtom($sCategoryPath);
                } elseif ($aPath[0] == 'feed') {
                    // show all posts in Atom format
                    $this->actionListAtom();
                } else {
                    // show posts by category
                    $this->actionList($aPath[0]);
                }

                
            } else if (count($aPath) == 0) {
                // show all posts
                $this->actionList();
            } else {
                throw new CHttpException(404,'The requested page does not exist.');
            }
            
        } else {
            // show all posts            
            $this->actionList();
        }
	}
    
    public function actionRatePost()
	{
        $nId = intval($_POST['id']);
        $nType = intval($_POST['type']);
        
        $aResult = array(
            'status' => 'failed'
        );
        
        if (Yii::app()->request->isAjaxRequest) {
            if(!Yii::app()->user->isGuest) 
            {
                $oPost = PublicationsPost::model()->findByPk($nId, 'status='.PublicationsPost::STATUS_PUBLISHED.' OR status='.PublicationsPost::STATUS_ARCHIVED);

                if ($oPost && $oPost->checkUserRating()) {
                    
                    $oPostRating = new PublicationsRating();
                    $oPostRating->author_id = Yii::app()->user->id;
                    $oPostRating->post_id = $oPost->id;
                    
                    $oAuthor = $oPost->author;
                    
                    if ($nType == 1) {
                        // +
                        $oPostRating->type = 1;
                        $oPost->rating = $oPost->rating + 1;
                        
                        $oAuthor->rating = $oAuthor->rating + 1;
                    } else {
                        // -
                        $oPostRating->type = 2;
                        $oPost->rating = $oPost->rating - 1;
                        
                        $oAuthor->rating = $oAuthor->rating - 1;
                    }
                    
                    $oPost->save();                    
                    $oAuthor->save();                    
                    $oPostRating->save();
                    
                    

                    $aResult = array(
                        'status' => 'success',
                        'rating' => $oPost->rating,
                        'id' => $oPost->id
                    );                
                }
            }
            
            header("Content-type: application/json");
            echo json_encode($aResult);
            Yii::app()->end();
        }
	}
    
    public function actionRateComment()
	{
        $nId = intval($_POST['id']);
        $nType = intval($_POST['type']);
        
        $aResult = array(
            'status' => 'failed'
        );
        
        if (Yii::app()->request->isAjaxRequest) {
            if(!Yii::app()->user->isGuest) 
            {
                $oComment = PublicationsComment::model()->findByPk($nId, 'status='.PublicationsComment::STATUS_APPROVED);

                if ($oComment && $oComment->checkUserRating()) {
                    
                    $oCommentRating = new PublicationsCommentsRating();
                    $oCommentRating->author_id = Yii::app()->user->id;
                    $oCommentRating->comment_id = $oComment->id;
                    
                    $oAuthor = $oComment->author;
                    
                    if ($nType == 1) {
                        // +
                        $oCommentRating->type = 1;
                        $oComment->rating = $oComment->rating + 1;
                        
                        $oAuthor->rating = $oAuthor->rating + 1;
                    } else {
                        // -
                        $oCommentRating->type = 2;
                        $oComment->rating = $oComment->rating - 1;
                        
                        $oAuthor->rating = $oAuthor->rating - 1;
                    }
                    
                    $oComment->saveNode();                    
                    $oAuthor->save();                    
                    $oCommentRating->save();
                    
                    

                    $aResult = array(
                        'status' => 'success',
                        'rating' => $oComment->rating,
                        'id' => $oComment->id
                    );                
                }
            }
            
            header("Content-type: application/json");
            echo json_encode($aResult);
            Yii::app()->end();
        }
	}
    
    public function actionList($sCategoryAlias = false, $sTagAlias = false)
    {
        $criteria=new CDbCriteria(array(
			'condition'=>'t.status='.PublicationsPost::STATUS_PUBLISHED,
			'order'=>'post_date DESC',
			'with'=>array('category', 'commentCount', 'author'),
		));
        
        $sAtomLink = 'http://'.$_SERVER['HTTP_HOST'].'/wave/feed'; 
        $sAtomLinkText = 'Публикации в формате ATOM';
        
        $sPageTitle = Yii::app()->getPage()->header;
        
        if ($sCategoryAlias) {
            $oCategory = $this->loadCategory($sCategoryAlias);     
            $criteria->addCondition("category.alias = '".$oCategory->alias."'");
            
            $sPageTitle = $oCategory->title;
            
            $sAtomLink = 'http://'.$_SERVER['HTTP_HOST'].'/wave/'.$sCategoryAlias.'.atom'; 
            $sAtomLinkText = 'Поток в формате ATOM';
        }        
        
		if($sTagAlias) {            
			$criteria->addSearchCondition('tags',$sTagAlias);
        }
        
        $oPagination = new CPagination();
        $oPagination->setPageSize(Yii::app()->params['postsPerPage']);

		$dataProvider=new CActiveDataProvider('PublicationsPost', array(
			'pagination'=> $oPagination,
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
        
        
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
            'pageTitle' => $sPageTitle,
            'atomLink' => $sAtomLink,
            'atomLinkText' => $sAtomLinkText
		));
    }
    
    public function actionListAtom($sCategoryAlias = false)
    {
        $this->layout = "";
        
        $criteria=new CDbCriteria(array(
			'condition'=>'t.status='.PublicationsPost::STATUS_PUBLISHED,
			'order'=>'post_date DESC',
			'with'=>array('category', 'commentCount', 'author'),
		));
        
        $sPageTitle = Yii::app()->getPage()->header;
        
        if ($sCategoryAlias) {
            $oCategory = $this->loadCategory($sCategoryAlias);     
            $criteria->addCondition("category.alias = '".$oCategory->alias."'");
            
            $sPageTitle = $oCategory->title;
        }
        
        $oPagination = new CPagination();
        $oPagination->setPageSize(20);

		$dataProvider=new CActiveDataProvider('PublicationsPost', array(
			'pagination'=> $oPagination,
			'criteria'=>$criteria,
		));
        
        $aData = $dataProvider->getData();
        
        $sPageTitle .= ' - '.Yii::app()->getSite()->name;
        
        header("Content-type: text/xml; charset=utf-8");
        $lastBuildDate = date(Yii::app()->params['DATE_FORMAT_ATOM']); 
        
        
        if ($sCategoryAlias) {
            $sUrl = 'http://'.$_SERVER['HTTP_HOST'].'/wave/'.$sCategoryAlias.'.atom';
        } else {
            $sUrl = 'http://'.$_SERVER['HTTP_HOST'].'/wave/feed';
        }
        
        echo '<?xml version="1.0" encoding="UTF-8"?>
                <feed xmlns="http://www.w3.org/2005/Atom">
                    <title>'.$sPageTitle.'</title>
                    <link rel="self" href="'.$sUrl.'"></link>
                    <id>'.$sUrl.'</id>
                    <updated>'.$lastBuildDate.'</updated>';
        
        if (count($aData)) {
            foreach ($aData as $itm) {
                $pos = mb_strpos($itm->content, "<!-- pagebreak -->");
                $url = 'http://'.$_SERVER['HTTP_HOST'].$itm->getUrl();
                $author_url = 'http://'.$_SERVER['HTTP_HOST'].$itm->author->getUrl();
                $text = $pos ? substr($itm->content, 0, $pos) : $itm->content;
                
                echo '<entry>
                          <id>'.$url.'</id>
                          <link type="text/html" rel="alternate" href="'.$url.'"></link>
                          <published>'.date(Yii::app()->params['DATE_FORMAT_ATOM'], strtotime($itm->post_date)).'</published>
                          <updated>'.date(Yii::app()->params['DATE_FORMAT_ATOM'], strtotime($itm->post_date)).'</updated>
                          <author>
                            <name>'.$itm->author->username.'</name>
                            <uri>'.$author_url.'</uri>
                          </author>
                          <title><![CDATA['.$itm->title.']]></title>
                          <content type="html">
                            <![CDATA['.$text.'<p><a href="'.$url.'">Читать дальше...</a></p>]]>
                          </content>
                    </entry>';
            }
        }
        
        echo "</feed>";
        die();        
    }
    
    public function actionView($sCategoryAlias, $sPostAlias)
	{
		$post = $this->loadModel($sCategoryAlias, $sPostAlias);
		$comment = $this->newComment($post);
        
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", $post->update_time)." GMT");

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}
    
    public function loadModel($sCategoryAlias, $sPostAlias)
	{
		if($this->_model===null)
		{
            $criteria=new CDbCriteria(array(
                'condition'=>"t.alias='".$sPostAlias."' AND category.alias='".$sCategoryAlias."' AND (status=".PublicationsPost::STATUS_PUBLISHED." OR status=".PublicationsPost::STATUS_ARCHIVED.')',
                'order'=>'update_time DESC',
                'with'=>'category',
            ));
            
            $this->_model = PublicationsPost::model()->find($criteria);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
    
    public function loadCategory($sCategoryAlias)
    {
        $model = null;
        $criteria=new CDbCriteria(array(
            'condition'=>"alias='".$sCategoryAlias."'",
        ));

        $model = PublicationsCategory::model()->find($criteria);
        if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
        
        return $model;
    }
    
    protected function newComment($post)
	{
		$comment=new PublicationsComment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='commentform')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['PublicationsComment']))
		{
            
			$comment->attributes=$_POST['PublicationsComment'];
			if($post->addComment($comment, intval($_POST['PublicationsComment']['parentId'])))
			{
				if($comment->status==PublicationsComment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
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