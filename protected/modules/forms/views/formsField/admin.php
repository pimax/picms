<?php
$this->breadcrumbs=array(
	'Forms Fields'=>array('index'),
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
                'id'=>'forms-field-grid',
                'dataProvider'=>$model->search(),
                'buttons' => array(
                    array(
                        'title' => Forms::t('Create form'),
                        'url'  => array('/forms/form/create')
                    )
                ),
                'columns'=>array(
                    'id',
                    'form_id',
                    'field_type',
                    'name',
                    'alias',
                    'pos',
                    /*
                    'params',
                    'required',
                    */
                    array(
                        'class'=>'CmsButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>