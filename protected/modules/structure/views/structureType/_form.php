<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'structure-type-form',
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
		<?php echo $form->labelEx($model,'module_id'); ?>
        <div class="input">
            <?php echo $form->dropDownList($model,'module_id',  ModulesItem::items(true)); ?>
            <?php echo $form->error($model,'module_id'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'controller_alias'); ?>
        <div class="input">
            <?php echo $form->textField($model,'controller_alias',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'controller_alias'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'action_alias'); ?>
        <div class="input">
            <?php echo $form->textField($model,'action_alias',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'action_alias'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'description'); ?>
        <div class="input">
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'params'); ?>
        <div class="input">
            <?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'params'); ?>
        </div>
	</div>

    <div class="well">
        <?php echo CHtml::submitButton($model->isNewRecord ? Structure::t('Create') : Structure::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Structure::t('Back'), array('/structure/structureType/admin'), array('class' => 'btn')); ?>        
    </div>

<?php $this->endWidget(); ?>