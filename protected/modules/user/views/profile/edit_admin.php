<?php 
$this->breadcrumbs=array(
	UserModule::t('Your profile')=>array('/user/profile'),
	UserModule::t('Edit profile'),
);

$this->pageMainHeader = UserModule::t("Profile");
$this->pageMainHeaderDescription = UserModule::t('Edit profile');
$this->pageTitle = UserModule::t('Edit profile');
?>
<section>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="clearfix">
		<?php echo $form->labelEx($profile,$field->varname);?>
        <div class="input">
		
        <?php 
		if ($field->widgetEdit($profile)) {
			echo $field->widgetEdit($profile, array('class' => 'text_input'));
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class' => 'text_area'));
		} else {
			echo $form->textField($profile,$field->varname,array('class' => 'text_input', 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo $form->error($profile,$field->varname); ?>
	</div>	
	</div>	
			<?php
			}
		}
?>
	<div class="clearfix">
		<?php echo $form->labelEx($model,'username'); ?>
        <div class="input">
            <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class' => 'text_input')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'email'); ?>
        <div class="input">
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class' => 'text_input')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
	</div>

	<div class="well">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</section>