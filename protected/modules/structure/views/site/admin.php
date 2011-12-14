<?php
$this->breadcrumbs=array(
	Structure::t('Sites')=>array('admin'),
	Structure::t('Manage'),
);

$this->pageMainHeader = Structure::t('Sites');
$this->pageMainHeaderDescription = Structure::t('Manage sites');
?>

<?php $this->widget('CmsDataGrid', array(
    'id'=>'site-item-grid',    
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Structure::t('Create site'),
            'url'  => array('/structure/site/create')
        )
    ),
    'columns'=>array(
        array(
            'name' => 'id',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'url',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'name',
            'class' => 'CmsDataGridColumn'
        ),
        array('class'=>'CmsButtonColumn'),
    ),
)); ?>