<?php 
$this->pageTitle = Yii::app()->params['title'] . ' - '.UserModule::t("Login");

$this->pageMainHeader = Yii::app()->params['title'];
$this->pageMainHeaderDescription = UserModule::t("Login");
?>

<section id="login-box">
    <?php echo CHtml::beginForm('', 'post', array(
        'class' => 'form'
    )); ?>

        <div class="clearfix">
            <?php echo CHtml::activeLabelEx($model,'username'); ?>
            
            <div class="input">
                <?php echo CHtml::activeTextField($model,'username') ?>
                <div class="errorMessageBox"><?php echo CHtml::error($model,'username'); ?></div>
            </div>
        </div>
    
        <div class="clearfix">
            <?php echo CHtml::activeLabelEx($model,'password'); ?>
            
            <div class="input">
                <?php echo CHtml::activePasswordField($model,'password') ?>
                <div class="errorMessageBox"><?php echo CHtml::error($model,'password'); ?></div>
            </div>
        </div>
    
        <div class="clearfix">
            <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
            
            <div class="input">
                <?php echo CHtml::activeCheckBox($model,'rememberMe') ?>
            </div>
        </div>

        <div class="well-simple">
            <?php echo CHtml::submitButton('Войти', array('class' => 'btn primary')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

</section> <!--! end of #login-box -->