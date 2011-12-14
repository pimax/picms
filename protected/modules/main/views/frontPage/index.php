<?php $this->pageTitle = Yii::app()->getPage()->meta_title.' - '.Yii::app()->getSite()->meta_title?>
<section class="publications-block">
    <header>
        <h1><?php echo Yii::app()->getPage()->header?></h1>
    </header>

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$publications,
        'itemView'=>'_post',
        'template'=>"{items}",
    )); ?>
    
    <section class="pagination">
        <a href="/wave" title="" class="front">Все публикации</a>   
    </section>
</section>

<section class="faces-block">
    <header>
        <h1><a href="/users">Новые пользователи</a></h1>
    </header>
    
    <?php foreach ($users as $itm):?>
        <article class="face-one-block">
            <div class="face-image">
                <?php if ($itm->profile->avatar):?>
                    <a href="/users/<?php echo $itm->username?>"><img class="avatar avatar-60 rounded photo" src="<?php echo Pi::getThumbUrl('/'.$itm->profile->avatar, 100, true)?>" /></a>
                <?php else:?>
                    <a href="/users/<?php echo $itm->username?>"><img class="avatar avatar-60 rounded photo" src="<?php echo Yii::app()->params['uploadsImagesUrl']; ?>/no_photo_100.png" alt="" /></a>
                <?php endif;?>
            </div>

            <div class="face-info">
                <a href="/users/<?php echo $itm->username?>" class="user-info-link"><?php echo $itm->username?></a>
            </div>
        </article>
    <?php endforeach;?>

    <div class="clearboth"><!-- ~ --></div>
    
    <section class="pagination">
        <a href="/users" title="" class="front2">Все пользователи</a>   
    </section>
</section>