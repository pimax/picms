<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>

<ul class="tabs">
    <li class="active"><a href="#tab-1">Общая информация</a></li>
    <li><a href="#tab-2">Мета-тэги</a></li>
    <li><a href="#tab-3">Дополнительные параметры</a></li>
</ul>

<div class="tab-content">  
    
    
    <div class="active" id="tab-1">
        <div class="clearfix">
            <?php echo $form->labelEx($model,'name'); ?>
            <div class="input">
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'url'); ?>
            <div class="input">
                <?php if (!$model->getIsNewRecord()):?>
                    <?php echo $form->hiddenField($model,'url',array('size'=>80,'maxlength'=>128)); ?>
                    <div class="item-permalink-box">
                        <span class="item-permalink">http://<?php echo $_SERVER['HTTP_HOST']?>/<?php if ($model->parent && $model->parent->path != '/'):?><?php echo $model->parent->path?>/<?php endif;?><span title="Нажмите, чтобы изменить эту часть постоянной ссылки" id="editable-item-name"><?php echo $model->url?></span></span>
                        <span id="item-permalink-buttons"><a id="item-permalink-button-edit" class="button" href="javascript:void(0)">Изменить</a></span>
                    </div>
                <?php else:?>
                    <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'url'); ?>
                <?php endif;?>
            </div>
        </div>

        <?php if ($model->id != 1):?>
            <div class="clearfix">
                <?php echo $form->labelEx($model,'parentId'); ?>
                <div class="input">
                    <?php echo $form->dropDownList($model,'parentId', Page::getPagesListData()); ?>
                    <?php echo $form->error($model,'parentId'); ?>
                </div>
            </div>
        <?php endif;?>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'header'); ?>
            <div class="input">
                <?php echo $form->textField($model,'header',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'header'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'type_id'); ?>
            <div class="input">
                <?php echo $form->dropDownList($model,'type_id', StructureType::items()); ?>
                <?php echo $form->error($model,'type_id'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'template_id'); ?>
            <div class="input">
                <?php echo $form->dropDownList($model,'template_id', Template::items(true)); ?>
                <?php echo $form->error($model,'template_id'); ?>
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
    </div>
    
    <div id="tab-2">
        <div class="clearfix">
            <?php echo $form->labelEx($model,'meta_title'); ?>
            <div class="input">
                <?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'meta_title'); ?>
            </div>
        </div>    

        <div class="clearfix">
            <?php echo $form->labelEx($model,'meta_keywords'); ?>
            <div class="input">
                <?php echo $form->textArea($model,'meta_keywords',array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'meta_keywords'); ?>
            </div>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($model,'meta_description'); ?>
            <div class="input">
                <?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'meta_description'); ?>
            </div>
        </div>
    </div> 
    
    <div id="tab-3">
        <div class="clearfix">
            <?php echo $form->labelEx($model,'allow_index'); ?>
            <div class="input">
                <?php echo $form->checkBox($model,'allow_index'); ?>
                <?php echo $form->error($model,'allow_index'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'show_in_menu'); ?>
            <div class="input">
                <?php echo $form->checkBox($model,'show_in_menu'); ?>
                <?php echo $form->error($model,'show_in_menu'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'show_in_sitemap'); ?>
            <div class="input">
                <?php echo $form->checkBox($model,'show_in_sitemap'); ?>
                <?php echo $form->error($model,'show_in_sitemap'); ?>
            </div>
        </div>
        
        <div class="clearfix">
            <?php echo $form->labelEx($model,'title_in_menu'); ?>
            <div class="input">
                <?php echo $form->textField($model,'title_in_menu',array('maxlength'=>128)); ?>
                <?php echo $form->error($model,'title_in_menu'); ?>
            </div>
        </div>   
    </div>
    
    
</div>

<div class="well">        
    <?php echo CHtml::submitButton($model->isNewRecord ? Structure::t('Create') : Structure::t('Save'), array('class' => 'btn primary')); ?>
    <?php echo CHtml::link(Structure::t('Back'), array('/structure/page/admin'), array('class' => 'btn')); ?>
</div>

<?php if ($model->getIsNewRecord()):?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#Page_name').translit({alias_box: "Page_url"});
        });
    </script>
<?php endif;?>

<?php $this->endWidget(); ?>