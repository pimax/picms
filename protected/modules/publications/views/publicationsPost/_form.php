

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'post-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'))); ?>
<?php echo CHtml::errorSummary($model); ?>

<ul class="tabs" data-tabs="tabs">
    <li class="active"><a href="#tab-1">Общая информация</a></li>
    <li><a href="#tab-2">Дополнительные параметры</a></li>
</ul>

<div class="form tab-content">
	
    
    <div class="active" id="tab-1">
    
        <div class="clearfix">
            <?php echo $form->labelEx($model,'title'); ?>
            <div class="input">
                <?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128)); ?>
                <?php echo $form->error($model,'title'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'alias'); ?>
            <div class="input">
                <?php if (!$model->getIsNewRecord()):?>
                    <?php echo $form->hiddenField($model,'alias',array('size'=>80,'maxlength'=>128)); ?>
                    <div class="item-permalink-box">
                        <span class="item-permalink">http://<?php echo $_SERVER['HTTP_HOST']?>/wave/<?php echo $model->category->alias?>/<span title="Нажмите, чтобы изменить эту часть постоянной ссылки" id="editable-item-name"><?php echo $model->alias?></span></span>
                        <span id="item-permalink-buttons"><a id="item-permalink-button-edit" class="button" href="javascript:void(0)">Изменить</a></span>
                    </div>
                <?php else:?>
                    <?php echo $form->textField($model,'alias',array('size'=>80,'maxlength'=>128)); ?>
                    <?php echo $form->error($model,'alias'); ?>
                <?php endif;?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'category_id'); ?>
            <div class="input">
                <?php echo $form->dropDownList($model,'category_id',PublicationsCategory::items()); ?>
                <?php echo $form->error($model,'category_id'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'post_date'); ?>
            <div class="input">
                <?php 
                     $this->widget('CJuiDateTimePicker',array(
                        'model'=>$model, //Model object
                        'attribute'=>'post_date', //attribute name
                        'mode'=>'datetime', //use "time","date" or "datetime" (default)
                        'options'=>array(
                            'timeFormat' => 'hh:mm:ss',
                            'showSecond' => true,
                            'timeText' => 'Время',
                            'hourText' => 'Часы',
                            'minuteText' => 'Минуты',
                            'secondText' => 'Секунды'
                        ) // jquery plugin options
                    ));
                ?>
                <?php echo $form->error($model,'post_date'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'content'); ?>
            <div class="input">
                <?php $this->widget('application.extensions.elRte.elRte', array(
                    'model' => $model,
                    'attribute' => 'content',
                 )); ?>
                <?php echo $form->error($model,'content'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'tags'); ?>
            <div class="input">
                <?php $this->widget('ext.picms.widgets.autoSuggest.autoSuggest', array(
                    'model'=>$model,
                    'attribute'=>'tags',
                    'url'=>array('suggestTags'),
                    'htmlOptions'=>array('size'=>50),
                )); ?>		
                <?php echo $form->error($model,'tags'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'status'); ?>
            <div class="input">
                <?php echo $form->dropDownList($model,'status',PublicationsLookup::items('PostStatus')); ?>
                <?php echo $form->error($model,'status'); ?>
            </div>
        </div>
    </div>
    
    <div id="tab-2">
        <div class="clearfix">
            <?php echo $form->labelEx($model,'image'); ?>
            <div class="input">
                <?php if ($model->image):?>
                    <img src="<?php echo Pi::getThumbUrl('/posts/'.$model->image, 100)?>" alt="" />
                    <br />     
                    <p><label><input type="checkbox" value="1" name="PublicationsPost[image_delete]" /> Удалить</label></p>
                <?php endif;?>
                <?php echo $form->fileField($model, 'image'); ?>		
                <?php echo $form->error($model,'image'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'main_image'); ?>
            <div class="input">
                <?php if ($model->main_image):?>
                    <img src="<?php echo Pi::getThumbUrl('/posts/'.$model->main_image, 100)?>" alt="" />
                    <br />  
                    <p><label><input type="checkbox" value="1" name="PublicationsPost[main_image_delete]" /> Удалить</label></p>
                <?php endif;?>
                <?php echo $form->fileField($model, 'main_image'); ?>		
                <?php echo $form->error($model,'main_image'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'show_on_main'); ?>
            <div class="input">
                <?php echo $form->checkBox($model,'show_on_main'); ?>
                <?php echo $form->error($model,'show_on_main'); ?>
            </div>
        </div>
    </div>
</div>

    <div class="well">        
        <?php echo CHtml::submitButton($model->isNewRecord ? Publications::t('Create') : Publications::t('Save'), array('class' => 'btn primary')); ?>
        <?php echo CHtml::link(Publications::t('Back'), array('/publications/publicationsPost/admin'), array('class' => 'btn')); ?>
    </div>
    
<?php if ($model->getIsNewRecord()):?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#PublicationsPost_title').translit({alias_box: "PublicationsPost_alias"});
        });
    </script>
<?php endif;?>

<?php $this->endWidget(); ?>