<?php $this->pageTitle = UserModule::t("Change password"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("Change password"); ?></h1>
    </header>


<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'password'); ?>
	<?php echo CHtml::activePasswordField($form,'password', array('class' => 'text_input')); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo CHtml::activePasswordField($form,'verifyPassword', array('class' => 'text_input')); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'button', 'id' => 'send')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
</section>