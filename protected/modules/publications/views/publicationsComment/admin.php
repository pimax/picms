<?php
$this->breadcrumbs=array(
	Publications::t('Comments') => array('index'),
	Publications::t('Manage'),
);

$this->pageMainHeader = Publications::t('Comments');
$this->pageMainHeaderDescription = Publications::t('Manage comments');
?>

<?php $this->widget('CmsDataGrid', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        array(
            'name' => 'author.username',
            'type' => 'raw',
            'header' => 'Автор',
            'class' => 'CmsDataGridColumn'
        ),                   
        array(
            'name'=>'content',
            'type'=>'text',
            'sortable' => false,
            'class' => 'CmsDataGridColumn'
        ),
        array(
            'name' => 'post.title',
            'class' => 'CmsDataGridColumn',
            'type' => 'raw',
            'header' => 'В ответ на',
            'value' => 'CHtml::link($data->post->title, array("publications/publicationsPost/update/id/".$data->post->id))'
        ),
        array(
            'header' => 'Статус',
            'type' => 'html',
            'class' => 'CmsDataGridColumn',
            'value'=> '$data->status==PublicationsComment::STATUS_PENDING ? "Ожидает проверки | ".CHtml::link("Одобрить", array("/publications/publicationsComment/approve/id/".$data->id)) : "Проверен"'
        ),
        array(
            'class'=>'CmsButtonColumn',
        ),
    ),
)); ?>