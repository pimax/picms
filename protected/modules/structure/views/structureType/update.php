<?php
$this->breadcrumbs=array(
	Structure::t('Structure Types')=>array('admin'),
	$model->name,
);

$this->pageMainHeader = Structure::t('Structure Types');
$this->pageMainHeaderDescription = $model->name;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>