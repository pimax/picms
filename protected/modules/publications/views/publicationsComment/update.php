<?php
$this->breadcrumbs=array(
	Publications::t('Comments') => array('index'),
	Publications::t('Update Comment').' #'.$model->id,
);

$this->pageMainHeader = Publications::t('Comments');
$this->pageMainHeaderDescription = Publications::t('Update Comment').' #'.$model->id;
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>