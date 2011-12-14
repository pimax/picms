<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form-form',
	'enableAjaxValidation'=>false,    
    'htmlOptions' => array(
        'class'=> 'block-content form'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?></p>
	</div>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'email_to'); ?>
		<?php echo $form->textField($model,'email_to',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_to'); ?></p>
	</div>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'email_from'); ?>
		<?php echo $form->textField($model,'email_from',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email_from'); ?></p>
	</div>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'template_id'); ?>
		<?php echo $form->textField($model,'template_id'); ?>
		<?php echo $form->error($model,'template_id'); ?></p>
	</div>

    <div class="_100">
		<p><?php echo $form->labelEx($model,'button_text'); ?>
		<?php echo $form->textField($model,'button_text',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'button_text'); ?></p>
	</div>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'captcha'); ?>
		<?php echo $form->checkBox($model,'captcha'); ?>
		<?php echo $form->error($model,'captcha'); ?></p>
	</div>

	<div class="_100">
		<p><?php echo $form->labelEx($model,'send_email'); ?>
		<?php echo $form->checkBox($model,'send_email'); ?>
		<?php echo $form->error($model,'send_email'); ?></p>
	</div>

    <div class="clear"></div>
    <div class="block-actions">
        <ul class="actions-left">
            <li><?php echo CHtml::link(Forms::t('Back'), array('/forms/form/admin'), array('class' => 'button red', 'id' => 'reset-validate-form')); ?></li>
        </ul>
        <ul class="actions-right">
            <li><?php echo CHtml::submitButton($model->isNewRecord ? Forms::t('Create') : Forms::t('Save'), array('class' => 'button')); ?></li>
        </ul>
    </div>

<?php $this->endWidget(); ?>