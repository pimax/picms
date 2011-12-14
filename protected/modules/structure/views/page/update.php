<?php
$this->breadcrumbs=array(
	Structure::t('Pages')=>array('admin'),
	$model->name
);

$this->pageMainHeader = Structure::t('Pages');
$this->pageMainHeaderDescription = $model->name;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>