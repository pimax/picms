<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'template-form',
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
        <?php echo $form->labelEx($model,'layout'); ?>
        <div class="input">
            <?php if ($model->id):?>
                <?php echo $model->layout;?>
            <?php else:?>
                <?php echo $form->textField($model,'layout',array('size'=>60,'maxlength'=>255)); ?>
            <?php endif;?>		
            <?php echo $form->error($model,'layout'); ?>
        </div>
    </div>


    <div class="clearfix">
        <?php echo $form->labelEx($model,'part_template'); ?>
        <div class="input">
        <?php echo $form->checkBox($model,'part_template')?>		
		<?php echo $form->error($model,'part_template'); ?>
        </div>
	</div>


    <div class="clearfix">
       <div>
            <?php $this->widget('ext.picms.widgets.codeMirror.codeMirror', array(                
                'value' => $model->getTemplateData(),
                'name'  => 'Template_data'
            ));?>
       </div>
    </div>    


<div class="well">
    <?php echo CHtml::submitButton($model->isNewRecord ? Structure::t('Create') : Structure::t('Save'), array('class' => 'btn primary')); ?>
    <?php echo CHtml::link(Structure::t('Back'), array('/structure/template/admin'), array('class' => 'btn')); ?>    
</div>

<?php $this->endWidget(); ?>