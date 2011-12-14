<?php
$this->breadcrumbs=array(
	Main::t('Modules')=>array('admin'),
	Main::t('Manage'),
);
$this->pageMainHeader = Main::t('Modules');
$this->pageMainHeaderDescription = Main::t('Manage modules');
?>

<?php $this->widget('CmsDataGrid', array(
    'id'=>'modules-item-grid',    
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Main::t('Create module'),
            'url'  => array('/main/modulesItem/create')
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
            'name' => 'module_alias',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'installed',
            'class' => 'CmsDataGridColumn',
            'value' => '$data->installed ? "Да" : "Нет"'
        ),
        array('class'=>'CmsButtonColumn'),
    ),
)); ?>
            