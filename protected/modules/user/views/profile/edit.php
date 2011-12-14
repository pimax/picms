<?php $this->pageTitle = UserModule::t("Profile"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t('Edit profile'); ?></h1>
    </header>

<?php echo $this->renderPartial('menu'); ?>

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
	<div class="row">
		<?php echo $form->labelEx($profile,$field->varname);
		
		if ($field->widgetEdit($profile)) {
			echo $field->widgetEdit($profile, array('class' => 'text_input'));
		} elseif ($field->range) {
			echo $form->radioButtonList($profile,$field->varname,Profile::range($field->range), array('labelOptions' => array('class' => 'inline'), 'separator' => '&nbsp;'));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class' => 'text_area', 'style' => 'width: auto'));
		} else {
			echo $form->textField($profile,$field->varname,array('class' => 'text_input', 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo $form->error($profile,$field->varname); ?>
	</div>	
			<?php
			}
		}
?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class' => 'text_input')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class' => 'text_input')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
    
    <h2 class="margin">Социальные сети</h2>
    
    <div class="row">
        <label>Facebook</label>
        <div>
            <?php if ($model->facebook_id):?>
                <a href="/user/disconnect/facebook">Открепить аккаунт</a>
            <?php else:?>
                для связки аккаунтов нажмите: <a href="/user/connect/facebook">Прикрепить</a>
            <?php endif;?>
        </div>
	</div>
    
    <div class="row">
        <label>ВКонтакте</label>
        <div>
            <?php if ($model->vkontakte_id):?>
                <a href="/user/disconnect/vkontakte">Открепить аккаунт</a>
            <?php else:?>
                для связки аккаунтов нажмите: <a href="/user/connect/vkontakte">Прикрепить</a>
            <?php endif;?>
        </div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'button', 'id' => 'send')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</section>