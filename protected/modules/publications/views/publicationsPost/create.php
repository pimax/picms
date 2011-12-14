<?php
$this->breadcrumbs=array(
	Publications::t('Publications Posts')=>array('admin'),
	Publications::t('Create'),
);

$this->pageMainHeader = Publications::t('Publications');
$this->pageMainHeaderDescription = Publications::t('Create Post');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>