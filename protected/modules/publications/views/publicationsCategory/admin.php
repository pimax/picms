<?php
$this->breadcrumbs=array(
	Publications::t('Publications Categories') => array('admin'),
	Publications::t('Manage'),
);

$this->pageMainHeader = Publications::t('Publications Categories');
$this->pageMainHeaderDescription = Publications::t('Manage categories');

?>
<?php $this->widget('CmsDataGrid', array(
    'id'=>'publications-category-grid',
    'dataProvider'=>$model->search(),
    'buttons' => array(
        array(
            'title' => Publications::t('Create category'),
            'url'  => array('/publications/publicationsCategory/create')
        )
    ),
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'id',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'title',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'alias',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'class'=>'CmsButtonColumn',
        ),
    ),
)); ?>