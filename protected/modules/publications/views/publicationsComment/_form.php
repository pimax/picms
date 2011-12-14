<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
    'htmlOptions' => array(
        'class'=> 'form'
    )
)); ?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'content'); ?>
        <div class="input">
            <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'content'); ?>
        </div>
	</div>

    <div class="well">
        <?php echo CHtml::submitButton($model->isNewRecord ? Publications::t('Create') : Publications::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Publications::t('Back'), array('/publications/publicationsComment/admin'), array('class' => 'btn')); ?>
    </div>

<?php $this->endWidget(); ?>