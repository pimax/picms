<?php
$this->breadcrumbs=array(
	Structure::t('Pages')=>array('admin'),
	Structure::t('Manage'),
);

$this->pageMainHeader = Structure::t('Pages');
$this->pageMainHeaderDescription = Structure::t('Manage pages');
?>
<?php $this->widget('ext.QTreeGridView.CQTreeGridView', array(
    'id'=>'page-grid',
    'ajaxUpdate' => false,
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Structure::t('Create page'),
            'url'  => array('/structure/page/create')
        )
    ),
    'columns'=>array(
        array(
            'name' => 'name',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'path',
            'class' => 'CmsDataGridColumn'
        ),
        array('class'=>'CmsButtonColumn'),
    ),
)); ?>