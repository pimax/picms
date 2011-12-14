<?php
$this->breadcrumbs=array(
	'Forms Fields'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormsField', 'url'=>array('index')),
	array('label'=>'Create FormsField', 'url'=>array('create')),
	array('label'=>'View FormsField', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FormsField', 'url'=>array('admin')),
);
?>

<h1>Update FormsField <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>