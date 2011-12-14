<?php $this->pageTitle = Yii::app()->getPage()->meta_title. ' - '.Yii::app()->getSite()->meta_title?>
<section class="map-block">
    <header>
        <h1><?php echo Yii::app()->getPage()->header ?></h1>
    </header>

    <?php if (count($pages)):?>
        <div>
            <h2>Страницы</h2>
            <ul class="simple">
                <?php foreach ($pages as $itm):?>
                    <li style="padding-left: <?php echo $itm->level * 20?>px"><?php echo CHtml::link($itm->name, $itm->path == '/' ? '/' : $itm->path);?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
    
    <div>
        <h2>Публикации</h2>
        <ul class="simple col2">
            <?php foreach ($publications1 as $itm):?>
                <li style="padding-left: 20px;"><?php echo CHtml::link($itm->title, $itm->url);?></li>
            <?php endforeach;?>
        </ul>
        <ul class="simple col2">
            <?php foreach ($publications2 as $itm):?>
                <li style="padding-left: 20px;"><?php echo CHtml::link($itm->title, $itm->url);?></li>
            <?php endforeach;?>
        </ul>
        <br class="clearboth" />
    </div>
    
    <div>
        <h2>Сообщество</h2>
        <ul class="simple">
            <li style="padding-left: 20px;"><?php echo CHtml::link('Пользователи', '/users');?></li>
        </ul>
    </div>
</section>
