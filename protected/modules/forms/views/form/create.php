<?php
$this->breadcrumbs=array(
	Forms::t('Forms')=>array('admin'),
	Forms::t('Create'),
);
?>
<div class="grid_6">
    <div class="block-border">
        <div class="block-header">
            <h1><?php echo Forms::t('Create Form')?></h1>
        </div>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>