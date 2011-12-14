<?php $this->pageTitle = UserModule::t("Login"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("Login"); ?></h1>
    </header>
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
<?php echo CHtml::beginForm('', 'post', array(
    
)); ?>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username', array('class' =>'text_input')) ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password', array('class' =>'text_input')) ?>
	</div>
	
	<div class="row">
		<p class="hint">
		<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
	
	<div class="row rememberMe">
		<?php echo CHtml::activeCheckBox($model,'rememberMe', array('class' => 'check_box')); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
	</div>
    
    <div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' =>'button', 'id' => 'send')); ?>
	</div>
    
    <h2 class="margin">Войти, как пользователь</h2>
    <div class="row">
        <?php Yii::app()->eauth->renderWidget(); ?>
        <div class="clearboth"></div>
    </div>

	
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>

</section>