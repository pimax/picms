<?php $this->pageTitle = 'Пользователи'. ' - '.Yii::app()->getSite()->meta_title;?>
<section>
    <header>
        <h1>Список пользователей</h1>
    </header>
    
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
        'template'=>"{items}\n{pager}",
        'pagerCssClass' => '',
        'pager' => array(
            'class' => 'ext.picms.widgets.pager.piPager'
        )
    )); ?>
    
</section>