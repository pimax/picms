<section id="feature_wrap">
    <div id="featured" class="newsslider">
        
        <?php foreach ($this->getFeaturedPosts() as $k => $itm):?>
            <article class="featured featured<?php echo $k+1?>">
                <a href="<?php echo $itm->getUrl()?>">
                    <span class="feature_excerpt">
                        <strong class="sliderheading"><?php echo $itm->title?></strong>
                        <span class="sliderdate"><?php echo Pi::showDate(strtotime($itm->post_date))?></span>
                        <span class="slidercontent">
                            <?php echo StringHelper::substr($itm->content, 0, 100) ?>
                        </span>
                    </span>
                    <img src="<?php echo Pi::showImageUrl('/posts/'.$itm->main_image)?>" alt="" />
                </a>
            </article><!-- end .featured -->
        <?php endforeach;?>

    </div><!-- end #featured --> 

    <span class="bottom_right_rounded_corner ie6fix"></span>
    <span class="bottom_left_rounded_corner ie6fix"></span>	

</section><!-- end featuredwrap -->