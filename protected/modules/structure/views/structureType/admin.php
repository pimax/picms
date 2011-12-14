<?php
$this->breadcrumbs=array(
	Structure::t('Structure Types')=>array('admin'),
	Structure::t('Manage'),
);

$this->pageMainHeader = Structure::t('Structure Types');
$this->pageMainHeaderDescription = Structure::t('Manage types');
?>
<?php $this->widget('CmsDataGrid', array(
    'id'=>'structure-type-grid',  
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Structure::t('Create type'),
            'url'  => array('/structure/structureType/create')
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
            'name' => 'module.name',
            'class' => 'CmsDataGridColumn'
        ),
        array('class'=>'CmsButtonColumn'),
    ),
)); ?>