<?php
$this->breadcrumbs=array(
	Forms::t('Forms')=>array('admin'),
	Forms::t('Update'),
);

?>
<div class="grid_6">
    <div class="block-border">
        <div class="block-header">
            <h1><?php echo Forms::t('Update Form').' #'.$model->id?></h1>
        </div>
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>