<?php $this->pageTitle = UserModule::t("List User"). ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1><?php echo UserModule::t("List User"); ?></h1>
    </header>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            array(
                'name' => 'username',
                'type'=>'raw',
                'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
            ),
            array(
                'name' => 'createtime',
                'value' => 'date("d.m.Y H:i:s",$data->createtime)',
            ),
            array(
                'name' => 'lastvisit',
                'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
            ),
        ),
    )); ?>
</section>