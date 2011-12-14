<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'class'=> 'form'
    )
)); ?>
    
    <?php echo $form->errorSummary($model); ?>
    
        <div class="clearfix">
            <?php echo $form->labelEx($model,'name'); ?>
            <div class="input">
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
        </div>
    
        <div class="clearfix">
            <?php echo $form->labelEx($model,'url'); ?>
            <div class="input">
                <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'url'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'template_id'); ?>
            <div class="input">
                <?php echo $form->dropDownList($model,'template_id', Template::items()); ?>
                <?php echo $form->error($model,'template_id'); ?>
            </div>
        </div>
    
        <div class="clearfix">
            <?php echo $form->labelEx($model,'meta_title'); ?>
            <div class="input">
                <?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'meta_title'); ?>
            </div>
        </div>	

        <div class="clearfix">
            <?php echo $form->labelEx($model,'counters'); ?>
            <div class="input">
                <?php echo $form->textArea($model,'counters',array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'counters'); ?>
            </div>
        </div>	

    <div class="well">
        <?php echo CHtml::submitButton($model->isNewRecord ? Structure::t('Create') : Structure::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Structure::t('Back'), array('/structure/site/admin'), array('class' => 'btn')); ?>        
    </div>

<?php $this->endWidget(); ?>