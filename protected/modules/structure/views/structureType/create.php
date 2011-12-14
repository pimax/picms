<?php
$this->breadcrumbs=array(
    Structure::t('Structure Types')=>array('admin'),
	Structure::t('Create'),
);

$this->pageMainHeader = Structure::t('Structure Types');
$this->pageMainHeaderDescription = Structure::t('Create StructureType');
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>