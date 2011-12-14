<section class="box box_small community_news">
    <header>
        <h1>Лучшие публикации</h1>
    </header>
    
    <?php foreach($this->getBestPosts() as $post): ?>
        <article class="entry box_entry">
            <h2><?php echo CHtml::link(CHtml::encode($post->title), $post->url); ?></h2>
            <?php if ($post->image):?>
                <?php echo CHtml::link('<img class="rounded" src="'.Pi::getThumbUrl('/posts/'.$post->image, 60).'" />', $post->url, array('class' => 'alignleft preloading_background')); ?>
            <?php endif;?>
            
            <?php echo StringHelper::substr($post->content, 0) ?>
            
            <div class="entry-mini-bottom">
                <?php echo CHtml::link('Читать далее', $post->url, array('class' => 'more-mini-link')); ?>
            </div>
        </article>
	<?php endforeach; ?>

</section>