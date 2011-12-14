<?php
$this->breadcrumbs=array(
	Structure::t('Templates')=>array('admin'),
	Structure::t('Create'),
);

$this->pageMainHeader = Structure::t('Templates');
$this->pageMainHeaderDescription = Structure::t('Create Template');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>