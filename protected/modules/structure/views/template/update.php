<?php
$this->breadcrumbs=array(
	Structure::t('Templates')=>array('admin'),
	$model->name,
);

$this->pageMainHeader = Structure::t('Templates');
$this->pageMainHeaderDescription = $model->name;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>