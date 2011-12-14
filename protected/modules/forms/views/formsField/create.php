<?php
$this->breadcrumbs=array(
	'Forms Fields'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormsField', 'url'=>array('index')),
	array('label'=>'Manage FormsField', 'url'=>array('admin')),
);
?>

<h1>Create FormsField</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>