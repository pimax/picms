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
        'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
    )); ?>

        <?php echo $form->errorSummary(array($model,$profile)); ?>

        <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username', array('class' => 'text_input')); ?>
        <?php echo $form->error($model,'username'); ?>
        </div>

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

        <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email', array('class' => 'text_input')); ?>
        <?php echo $form->error($model,'email'); ?>
        </div>

    <?php 
            $profileFields=$profile->getFields();
            if ($profileFields) {
                foreach($profileFields as $field) {
                ?>
        <div class="row">
            <?php echo $form->labelEx($profile,$field->varname); ?>
            <?php 
            if ($field->widgetEdit($profile)) {
                echo $field->widgetEdit($profile, array('class' => 'text_input'));
            } elseif ($field->range) {
                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
                echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class' => 'text_area'));
            } else {
                echo $form->textField($profile,$field->varname,array('class' => 'text_input', 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
            }
             ?>
            <?php echo $form->error($profile,$field->varname); ?>
        </div>	
                <?php
                }
            }
    ?>
        <?php if (UserModule::doCaptcha('registration')): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>

            <?php $this->widget('CCaptcha', array('clickableImage' => true, 'showRefreshButton' => false, 'imageOptions' => array('title' => 'Обновить'))); ?>
            <p class="hint"><?php echo $form->textField($model,'verifyCode', array('class' => 'text_input')); ?></p>
            <?php echo $form->error($model,'verifyCode'); ?>

            <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
            <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
        </div>
        <?php endif; ?>

        <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'button', 'id' => 'send')); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <?php endif; ?>
</section>