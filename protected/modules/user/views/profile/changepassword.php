<?php $this->pageTitle = UserModule::t("Change password"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("Change password"); ?></h1>
    </header>
    
<?php echo $this->renderPartial('menu'); ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password', array('class' => 'text_input')); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
        <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword', array('class' => 'text_input')); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'button', 'id' => 'send')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</section>