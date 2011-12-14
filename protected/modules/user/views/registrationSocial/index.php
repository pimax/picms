<?php $this->pageTitle = UserModule::t("Registration"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("Registration"); ?></h1>
    </header>

    <?php if(Yii::app()->user->hasFlash('registration')): ?>
    <div class="success">
    <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>
    <?php else: ?>

    <div class="form">
    <?php $form=$this->beginWidget('UActiveForm', array(
        'id'=>'registration-form',
        'enableAjaxValidation'=>true,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
    )); ?>

        <?php echo $form->errorSummary(array($model)); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'first_name'); ?>
            <?php echo $form->textField($model,'first_name', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'first_name'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'last_name'); ?>
            <?php echo $form->textField($model,'last_name', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'last_name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'button', 'id' => 'send')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <?php endif; ?>
</section>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#RegistrationSocialForm_email').focus();
    });
</script>