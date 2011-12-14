<?php
$this->breadcrumbs=array(
	Main::t('Modules')=>array('admin'),
	$model->name
);
$this->pageMainHeader = Main::t('Modules');
$this->pageMainHeaderDescription = Main::t('Update ModulesItem').' #'.$model->id;
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    