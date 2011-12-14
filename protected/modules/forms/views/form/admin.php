<?php
$this->breadcrumbs=array(
	Forms::t('Forms')=>array('admin'),
	Forms::t('Manage'),
);
?>
<div class="grid_12">
    <div class="block-border">
        <div class="block-header">
            <h1><?php echo Forms::t('Forms')?></h1>
        </div>
        <div class="block-content">
            <?php $this->widget('CmsDataGrid', array(
                'id'=>'form-grid',
                'dataProvider'=>$model->search(),
                'buttons' => array(
                    array(
                        'title' => Forms::t('Create form'),
                        'url'  => array('/forms/form/create')
                    )
                ),
                'columns'=>array(
                    'id',
                    'name',  
                    array(
                        'header' => 'Вопросы',
                        'type' => 'html',
                        'value' => '"<a href=#>15</a>&nbsp;[<a href=#>+</a>]"'
                    ),                    
                    array(
                        'header' => 'Результаты',
                        'type' => 'html',
                        'value' => '"<a href=#>145</a>&nbsp;[<a href=#>+</a>]"'
                    ),
                    array(
                        'class'=>'CmsButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>