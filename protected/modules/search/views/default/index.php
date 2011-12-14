<?php $this->pageTitle = Yii::app()->getPage()->meta_title. ' - '.Yii::app()->getSite()->meta_title?>
<section class="search-block">
    <header>
        <h1><?php echo Yii::app()->getPage()->header ?></h1>
    </header>

    <div class="search-full-form">
        <form action="/search" method="post">
            <input type="text" name="s" value="<?php echo $query?>" class="text_input" />
            <input type="submit" value="Найти" class="button" id="send" />
        </form>
    </div>
</section>

<?php if ($query):?>

    <?php if ($page != 'detail_users'):?>
        <section class="search-block">
            <header>
                <h2>Публикации</h2>
            </header>

            <?php if ($posts_count > 0):?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$posts,
                    'itemView'=>'_post',
                    'template'=>"{items}\n{pager}",
                    'pager' => array(
                        'class' => 'ext.picms.widgets.pager.piPager'
                    )
                )); ?>
            
                <?php if ($page == 'index'):?>
                    <div>
                        <a href="/search/posts">Всего найдено: <?php echo $posts_count?></a>
                    </div>
                <?php endif;?>
            <?php else:?>
                <p>Не найдено.</p>
            <?php endif;?>
        </section>
    <?php endif;?>

    <?php if ($page != 'detail_posts'):?>
        <section class="search-block">
            <header>
                <h2>Пользователи</h2>
            </header>

            <?php if ($users_count > 0):?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$users,
                    'itemView'=>'_user',
                    'template'=>"{items}\n{pager}",
                    'pager' => array(
                        'class' => 'ext.picms.widgets.pager.piPager'
                    )
                )); ?>
            
                <?php if ($page == 'index'):?>
                    <div style="margin-top: 40px;">
                        <a href="/search/users">Всего найдено: <?php echo $users_count?></a>
                    </div>
                <?php endif;?>
            <?php else:?>
                <p>Не найдено.</p>
            <?php endif;?>
        </section>
    <?php endif;?>
<?php endif;?>