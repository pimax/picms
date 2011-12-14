<?php
$this->breadcrumbs=array(
	Publications::t('Publications Posts')=>array('admin'),
	$model->title
);
$this->pageMainHeader = Publications::t('Publications');
$this->pageMainHeaderDescription = CHtml::encode($model->title);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>