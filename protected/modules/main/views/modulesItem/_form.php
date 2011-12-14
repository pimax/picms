<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'modules-item-form',
    
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'class' => 'form',
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'name'); ?>
		<div class="input">
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?></div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'module_alias'); ?>
		<div class="input"><?php echo $form->textField($model,'module_alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'module_alias'); ?></div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'description'); ?>
		<div class="input">
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>
	</div>

	<div class="clearfix">
        <?php echo $form->labelEx($model,'installed'); ?>
		<div class="input">
            <?php echo $form->checkBox($model,'installed'); ?>
            <?php echo $form->error($model,'installed'); ?>
        </div>
	</div>
    
    <div class="well">        
        <?php echo CHtml::submitButton($model->isNewRecord ? Main::t('Create') : Main::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Main::t('Back'), array('/main/modulesItem/admin'), array('class' => 'btn')); ?>
    </div>

<?php $this->endWidget(); ?>