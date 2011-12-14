<?php
$this->breadcrumbs=array(
	Structure::t('Templates')=>array('admin'),
	Structure::t('Manage'),
);

$this->pageMainHeader = Structure::t('Templates');
$this->pageMainHeaderDescription = Structure::t('Manage Templates');
?>
<?php $this->widget('CmsDataGrid', array(
    'id'=>'template-grid',
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Structure::t('Create template'),
            'url'  => array('/structure/template/create')
        )
    ),
    'columns'=>array(
        array(
            'name' => 'id',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'name',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'layout',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'class'=>'CmsButtonColumn',
        ),
    ),
)); ?>