<?php
$this->breadcrumbs=array(
	Publications::t('Publications Categories')=>array('admin'),
	$model->title
);

$this->pageMainHeader = Publications::t('Publications Categories');
$this->pageMainHeaderDescription = $model->title;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>