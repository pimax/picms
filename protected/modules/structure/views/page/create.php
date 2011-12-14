<?php
$this->breadcrumbs=array(
	Structure::t('Pages')=>array('admin'),
	Structure::t('Create'),
);

$this->pageMainHeader = Structure::t('Pages');
$this->pageMainHeaderDescription = Structure::t('Create Page');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>