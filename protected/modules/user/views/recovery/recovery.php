<?php $this->pageTitle = UserModule::t("Restore password"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("Restore password"); ?></h1>
    </header>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email', array('class' => 'text_input')) ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'button', 'id' => 'send')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>
</section>