<div id="comment_new_box">
    <div class="form" id="comment_form">

        <?php if (!Yii::app()->user->isGuest):?>    
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'commentform',
                'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ) 
            ));?>


            
            <div class="message_data">
                <?php echo $form->hiddenField($model, 'parentId');?>
                <?php echo $form->labelEx($model,'content'); ?>
                    <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>20, 'class' => 'text_area')); ?>
                    <?php echo $form->error($model,'content'); ?>

                <p class="submit_par"><?php echo CHtml::submitButton('Комментировать', array('class' => 'button', 'id' => 'submit')); ?></p>
            </div>
        
            <div class="clearboth"></div>



            <?php $this->endWidget(); ?>
        <?php else:?>
            <p>Оставлять комментарии могут только зарегистрированные пользователи.</p>
        <?php endif;?>

    </div><!-- form -->
</div>