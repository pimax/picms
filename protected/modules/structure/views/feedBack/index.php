<?php $this->pageTitle = Yii::app()->getPage()->meta_title. ' - '.Yii::app()->getSite()->meta_title?>
<section class="publications-block">
    <header>
        <h1><?php echo Yii::app()->getPage()->header ?></h1>
    </header>

    <?php echo Yii::app()->getPage()->content?>
</section>

<section class="feedback-block">
    <h2>Форма обратной связи</h2>

    <?php if(Yii::app()->user->hasFlash('contact')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>

    <?php else: ?>

    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contact-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email', array('class' => 'text_input')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'subject'); ?>
            <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128, 'class' => 'text_input')); ?>
            <?php echo $form->error($model,'subject'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'body'); ?>
            <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class' => 'text_area', 'style' => 'width: 400px;')); ?>
            <?php echo $form->error($model,'body'); ?>
        </div>

        <?php if(CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
            <?php $this->widget('CCaptcha', array('clickableImage' => true, 'showRefreshButton' => false, 'imageOptions' => array('title' => 'Обновить'))); ?>
            <p class="hint"><?php echo $form->textField($model,'verifyCode', array('class' => 'text_input')); ?></p>
            </div>
            <p class="hint">Пожалуйста, введите буквы, показанные на картинке выше.
            <br/>Регистр значения не имеет.</p>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
        <?php endif; ?>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Отправить', array('id' => 'send', 'class' => 'button')); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->

    <?php endif; ?>
</section>
