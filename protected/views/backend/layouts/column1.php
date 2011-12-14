<?php $this->beginContent('//layouts/main'); ?>
    
    <div class="span16">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('ext.picms.widgets.breadcrumbs.CmsBreadcrumbs', array(
                'tagName' => 'ul',
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif?>

        <?php echo $content; ?>
    </div>

<?php $this->endContent(); ?>
