<article class="entry">			
    <div class="entry-content">
        <h2 class="entry-heading"><?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?></h2>
        <div class="entry-head">
            <span class="date ie6fix"><?php echo Pi::showDate(strtotime($data->post_date))?></span>
            <span class="comments ie6fix"><?php echo CHtml::link($data->commentCount, $data->url.'#comments'); ?></span>
            <span class="rating ie6fix"><?php echo CHtml::link($data->rating, $data->url.'#rating'); ?></span>
            <span class="author ie6fix"><a href="/users/<?php echo $data->author->username?>"><?php echo $data->author->username?></a></span>						
            <span class="category ie6fix"><?php echo CHtml::link($data->category->title, $data->category->url); ?></span>
        </div>

        <?php if ($data->image):?>
            <div class="entry-previewimage rounded preloading_background">
                <?php echo CHtml::link('<img src="'.Pi::showImageUrl('/posts/'.$data->image).'" style="float: left; margin-right: 10px;" />', $data->url); ?>
            </div>
        <?php endif;?>

        <div class="entry-text">
            <?php
                $pos = mb_strpos($data->content, "<!-- pagebreak -->");
                if ($pos) {
                    echo substr($data->content, 0, $pos);
                } else {
                    echo $data->content;
                }
            ?>
        </div>

        <div class="entry-bottom">
            <?php if($data->tagLinks):?><span class="categories"><?php echo implode(', ', $data->tagLinks); ?></span><?php endif;?>
            <?php echo CHtml::link('Читать далее', $data->url, array('class' => 'more-link')); ?>
        </div>
    </div><!--end entry_content-->
</article><!--end entry -->