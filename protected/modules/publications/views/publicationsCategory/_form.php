<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'publications-category-form',
	'enableAjaxValidation'=>false,    
    'htmlOptions' => array(
        'class'=> 'form'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'title'); ?>
        <div class="input">
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'alias'); ?>
        <div class="input">
            <?php if (!$model->getIsNewRecord()):?>
                <?php echo $form->hiddenField($model,'alias',array('size'=>80,'maxlength'=>128)); ?>
                <div class="item-permalink-box">
                    <span class="item-permalink">http://<?php echo $_SERVER['HTTP_HOST']?>/wave/<span title="Нажмите, чтобы изменить эту часть постоянной ссылки" id="editable-item-name"><?php echo $model->alias?></span></span>
                    <span id="item-permalink-buttons"><a id="item-permalink-button-edit" class="button" href="javascript:void(0)">Изменить</a></span>
                </div>
            <?php else:?>
                <?php echo $form->textField($model,'alias',array('size'=>80,'maxlength'=>128)); ?>
                <?php echo $form->error($model,'alias'); ?>
            <?php endif;?>
        </div>
	</div>	

    <div class="well">
        <?php echo CHtml::submitButton($model->isNewRecord ? Publications::t('Create') : Publications::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Publications::t('Back'), array('/publications/publicationsCategory/admin'), array('class' => 'btn')); ?></li>        
    </div>

<?php if ($model->getIsNewRecord()):?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#PublicationsCategory_title').translit({alias_box: "PublicationsCategory_alias"});
        });
    </script>
<?php endif;?>

<?php $this->endWidget(); ?>