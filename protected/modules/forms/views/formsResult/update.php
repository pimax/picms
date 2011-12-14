<?php
$this->breadcrumbs=array(
	'Forms Results'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormsResult', 'url'=>array('index')),
	array('label'=>'Create FormsResult', 'url'=>array('create')),
	array('label'=>'View FormsResult', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FormsResult', 'url'=>array('admin')),
);
?>

<h1>Update FormsResult <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>