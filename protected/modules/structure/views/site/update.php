<?php
$this->breadcrumbs=array(
	Structure::t('Sites')=>array('admin'),
	$model->name,
);

$this->pageMainHeader = Structure::t('Sites');
$this->pageMainHeaderDescription = $model->name;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>