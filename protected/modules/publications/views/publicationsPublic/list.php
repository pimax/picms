<?php
$this->pageTitle=$pageTitle.' - '.Yii::app()->getSite()->meta_title;
?>
<section class="publications-block">
    <header>
        <h1><?php echo $pageTitle?><small><a href="<?php echo $atomLink?>"><?php echo $atomLinkText?></a></small></h1>
        <div class="clearboth"><!-- ~ --></div>
    </header>

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'id' => '',
        'itemView'=>'_view',
        'template'=>"{items}\n{pager}",
        'pagerCssClass' => '',
        'pager' => array(
            'class' => 'ext.picms.widgets.pager.piPager'
        )
    )); ?>
</section>