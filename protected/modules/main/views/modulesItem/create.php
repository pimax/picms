<?php
$this->breadcrumbs=array(
	Main::t('Modules')=>array('admin'),
	Main::t('Create'),
);
$this->pageMainHeader = Main::t('Modules');
$this->pageMainHeaderDescription = Main::t('Create ModulesItem');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>