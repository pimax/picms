<?php

class PublicationsPostController extends BackEndController
{
    public $defaultAction = 'admin';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PublicationsPost;
		if(isset($_POST['PublicationsPost']))
		{
            $_POST['PublicationsPost']['post_date'] = date("Y-m-d H:i:s", strtotime($_POST['PublicationsPost']['post_date']));
			$model->attributes=$_POST['PublicationsPost'];
            
            $image = CUploadedFile::getInstance($model,'image');
            if ($image)  $model->image = md5(time().rand(10000, 99999)).'.'.$image->getExtensionName();
            $main_image = CUploadedFile::getInstance($model,'main_image');
            if ($main_image)  $model->main_image = md5(time().rand(10000, 99999)).'.'.$main_image->getExtensionName();
            
			if($model->save()) {
                if ($image) {
                    $image->saveAs(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->image);
                }
                
                if ($main_image) {
                    $main_image->saveAs(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->main_image);
                }
                
				$this->redirect(array('admin'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		if(isset($_POST['PublicationsPost']))
		{
            if (empty($_POST['PublicationsPost']['image_delete'])) {
                $_POST['PublicationsPost']['image'] = $model->image;
            } else {
                unlink(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->image);
                $model->image = "";
            }
            if (empty($_POST['PublicationsPost']['main_image_delete'])) {
                $_POST['PublicationsPost']['main_image'] = $model->main_image;
            } else {
                unlink(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->main_image);
                $model->main_image = "";
            }
            
			$model->attributes=$_POST['PublicationsPost'];
            
            $image = CUploadedFile::getInstance($model,'image');
            if ($image)  $model->image = md5(time().rand(10000, 99999)).'.'.$image->getExtensionName();
            $main_image = CUploadedFile::getInstance($model,'main_image');
            if ($main_image)  $model->main_image = md5(time().rand(10000, 99999)).'.'.$main_image->getExtensionName();
            
			if($model->save()) {
                if ($image) {
                    $image->saveAs(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->image);
                }
                
                if ($main_image) {
                    $main_image->saveAs(Yii::app()->params['uploadsImagesPath'].'/posts/'.$model->main_image);
                }
                
				$this->redirect(array('admin'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PublicationsPost('search');
		if(isset($_GET['PublicationsPost']))
			$model->attributes=$_GET['PublicationsPost'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
   	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=PublicationsTag::model()->suggestTags($keyword);
            
			header("Content-type: application/json");
            echo json_encode($tags);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.PublicationsPost::STATUS_PUBLISHED.' OR status='.PublicationsPost::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=PublicationsPost::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
