<?php
$this->breadcrumbs=array(
	Publications::t('Publications Posts')=>array('admin'),
	Publications::t('Manage'),
);
$this->pageMainHeader = Publications::t('Publications Posts');
$this->pageMainHeaderDescription = Publications::t('Manage posts');
?>

<?php $this->widget('CmsDataGrid', array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'buttons' => array(
        array(
            'title' => Publications::t('Create post'),
            'url'  => array('/publications/publicationsPost/create')
        )
    ),
    'columns'=>array(
        array(
            'name' => 'title',
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name'=>'category_id',
            'class' => 'CmsDataGridColumn',
            'value'=>'PublicationsCategory::item($data->category_id)',
            'filter'=>PublicationsCategory::items(),
        ),

        array(
            'name'=>'post_date',
            'class' => 'CmsDataGridColumn',
            'type'=>'datetime',
            'filter'=>false,
            'value' => 'strtotime($data->post_date)'
        ),
        array(
            'class'=>'CmsButtonColumn',
        ),
    ),
)); ?>