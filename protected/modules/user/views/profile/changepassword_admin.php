<?php 
$this->breadcrumbs=array(
	UserModule::t('Your profile')=>array('/user/profile'),
	UserModule::t('Change password'),
);

$this->pageMainHeader = UserModule::t("Profile");
$this->pageMainHeaderDescription = UserModule::t('Change password');
$this->pageTitle = UserModule::t('Change password');
?>

<section>

<div class="form">
    <?php $form=$this->beginWidget('UActiveForm', array(
        'id'=>'changepassword-form',
        'enableAjaxValidation'=>true,
    )); ?>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="clearfix">
        <?php echo $form->labelEx($model,'password'); ?>
        <div class="input">
            <?php echo $form->passwordField($model,'password', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint">
                <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>
        </div>
	</div>
	
	<div class="clearfix">
        <?php echo $form->labelEx($model,'verifyPassword'); ?>
        <div class="input">
            <?php echo $form->passwordField($model,'verifyPassword', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>
	</div>
	
	
	<div class="well">
        <?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</section>