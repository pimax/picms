<?php
$this->breadcrumbs=array(
	'Forms Results'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormsResult', 'url'=>array('index')),
	array('label'=>'Manage FormsResult', 'url'=>array('admin')),
);
?>

<h1>Create FormsResult</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>