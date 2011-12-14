<?php
$this->breadcrumbs=array(
	'Forms Results'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FormsResult', 'url'=>array('index')),
	array('label'=>'Create FormsResult', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('forms-result-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Forms Results</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'forms-result-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'form_id',
		'content',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
