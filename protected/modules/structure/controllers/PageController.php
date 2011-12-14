<?php

class PageController extends BackEndController
{
    public $defaultAction = 'admin';
    
    public $CQtreeGreedView  = array (
        'modelClassName' => 'Page', 
        'adminAction' => 'admin'
    );
    
    public function actions() {
        return array (
            'create'=>'ext.QTreeGridView.actions.Create',
            'update'=>'ext.QTreeGridView.actions.Update',
            'delete'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            //'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
        );
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Page;
        

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Page']))
		{
            $parent = Page::model()->findByPk(intval($_POST['Page']['parentId']));            
			$model->attributes = $_POST['Page'];
            $model->site_id = 1;            
			if($model->appendTo($parent)) {
                $model->path = $this->getPathForPage($model);
                $model->saveNode();
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
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);   
        

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Page']))
		{
            $nParentId = isset($_POST['Page']['parentId']) ? intval($_POST['Page']['parentId']) : 0;
        
            $bMoveNode = false;

            if (!$model->isRoot()) {
                $parent = $model->parent;
                if ($parent->id != $nParentId && $nParentId != $model->id) {
                    $bMoveNode = true;
                }
            }
            
			$model->attributes = $_POST['Page'];
            
            if ($bMoveNode) {
                $to = Page::model()->findByPk($nParentId);
                
                if($model->moveAsLast($to)) {
                    $model->path = $this->getPathForPage($model);
                    $model->saveNode();
                    $this->redirect(array('admin'));
                }
            } else {
                if($model->saveNode()) {
                    $model->path = $this->getPathForPage($model);
                    $model->saveNode();
                    $this->redirect(array('admin'));
                }
            }
            
			
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->deleteNode();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Page::model()->findByPk($id);
		if($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
        } else {
            if ($model->parent) {
                $model->parentId = $model->parent->id;
            } else {
                $model->parentId = 0;
            }
        }
        
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    protected function getPathForPage(Page $oPage)
    {
        return Page::getPathForPage($oPage);
    }
}
