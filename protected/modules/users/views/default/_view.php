<article class="people">
    <div class="image">
        <?php if ($data->profile->avatar):?>
            <a href="/users/<?php echo $data->username?>"><img class="avatar avatar-60 rounded photo" src="<?php echo Pi::getThumbUrl('/'.$data->profile->avatar, 100, true)?>" /></a>
        <?php else:?>
            <a href="/users/<?php echo $data->username?>"><img class="avatar avatar-60 rounded photo" src="<?php echo Yii::app()->params['uploadsImagesUrl']; ?>/no_photo_100.png" alt="" /></a>
        <?php endif;?>
    </div>
    <div class="info">
        <div class="label">Имя:</div>
        <div class="labeled"><a href="/users/<?php echo $data->username?>"><?php echo $data->profile->firstname?> <?php echo $data->profile->lastname?></a></div>
        <div class="label">Логин:</div>
        <div class="labeled"><?php echo $data->username?></div>
        <div class="label">Рейтинг:</div>
        <div class="labeled"><?php echo $data->rating?></div>
        <?php /* <div class="online">Online</div> */ ?>
    </div>
    <div class="actions">
        <?php /* <a href="#">Написать сообщение</a>
        <a href="#">Добавить в друзья</a>
        <div class="load_result"></div> */ ?>
    </div>
    <br class="clearboth" />
</article>