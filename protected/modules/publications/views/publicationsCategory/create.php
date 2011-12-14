<?php
$this->breadcrumbs=array(
	Publications::t('Publications Categories')=>array('admin'),
	Publications::t('Create'),
);

$this->pageMainHeader = Publications::t('Publications Categories');
$this->pageMainHeaderDescription = Publications::t('Create PublicationsCategory');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>