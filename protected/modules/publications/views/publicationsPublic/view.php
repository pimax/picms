<?php
$this->breadcrumbs=array(
    Yii::app()->getPage()->header => Yii::app()->getPage()->path,
	$model->title,
);
$this->pageTitle=$model->title.' - '.Yii::app()->getSite()->meta_title
?>

<section class="publications-block">
    <header>
        <h1><?php echo CHtml::encode($model->title)?></h1>
    </header>

    <article class="entry">			
        <div class="entry-content entry-full-content">
            <div class="entry-head">
                <span class="date ie6fix"><?php echo Pi::showDate(strtotime($model->post_date))?></span>
                <span class="comments ie6fix"><?php echo CHtml::link($model->commentCount, $model->url.'#comments'); ?></span>
                <span class="rating ie6fix"><?php echo CHtml::link($model->rating, $model->url.'#rating', array('id' => 'entry-rating-link')); ?></span>
                <span class="author ie6fix"><a href="/users/<?php echo $model->author->username?>"><?php echo $model->author->username?></a></span>						
                <span class="category ie6fix"><?php echo CHtml::link($model->category->title, $model->category->url); ?></span>
            </div>

            <?php if ($model->image):?>
                <div class="entry-previewimage entry-previewimage-no-link rounded preloading_background">
                    <img src="<?php echo Pi::showImageUrl('/posts/'.$model->image)?>" style="float: left; margin-right: 10px;" />
                </div>
            <?php endif;?>

            <div class="entry-text">
                <?php
                    echo $model->content;
                ?>
            </div>

            <div class="entry-full-bottom">
                <div class="nav-previous">
                    <?php if ($oPrevPost = $model->getPreviousPost()):?>
                        <a rel="prev" href="<?php echo $oPrevPost->getUrl()?>"><span class="meta-nav">←</span> <?php echo $oPrevPost->title?></a>
                    <?php endif;?>
                </div>
                <div class="nav-next">
                    <?php if ($oNextPost = $model->getNextPost()):?>
                        <a rel="next" href="<?php echo $oNextPost->getUrl()?>"><?php echo $oNextPost->title?> <span class="meta-nav">→</span></a>
                    <?php endif;?>
                </div>
                <br class="clearboth" />
            </div>
        </div><!--end entry_content-->
    </article><!--end entry -->
    <br class="clearboth" /> 
    
    
    <div class="entry-adv-block">
        <div class="entry-rating-box" id="rating">
            <h4 class="entry-rating-header">Рейтинг</h4>
            <div id="post-rating-plus-box" class="entry-rating-button"><?php if ($model->checkUserRating()):?><?php echo CHtml::ajaxLink('+', '/wave/rate', array('data' => array('id' => $model->id, 'type' => 1), 'type' => 'post', 'success' => 'FDB.AJAX.ratePostSuccess'))?><?php else:?>+<?php endif;?></div>
            <div id="post-rating-count-box" class="entry-rating-count"><?php echo $model->rating?></div>
            <div id="post-rating-minus-box" class="entry-rating-button"><?php if ($model->checkUserRating()):?><?php echo CHtml::ajaxLink('-', '/wave/rate', array('data' => array('id' => $model->id, 'type' => 2), 'type' => 'post', 'success' => 'FDB.AJAX.ratePostSuccess'))?><?php else:?>-<?php endif;?></div>
            <br class="clearboth" />
        </div>
        <div class="entry-info-box">
            <h4><?php echo CHtml::encode($model->title)?></h4>
            <div>Добавил <a class="user-link" href="/users/<?php echo $model->author->username?>"><?php echo $model->author->username?></a>, <?php echo Pi::showDateTime(strtotime($model->post_date))?></div>
            <div><span>Тэги: </span><?php echo implode(', ', $model->tagLinks); ?></div>
        </div>
        <br class="clearboth" />
    </div>
    
    <div class="entry-social-block">
        <div class="social-icon-title">Поделиться</div>
        
        <div class="social-icon-facebook">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=199678970104808";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
        </div>
        
        <div class="social-icon-vkontakte">
            <script type="text/javascript">
              VK.init({apiId: 2634817, onlyWidgets: true});
            </script>

            <div id="vk_like"></div>
            <script type="text/javascript">
            VK.Widgets.Like("vk_like", {type: "mini"});
            </script>
        </div>             
        
        <div class="social-icon-twitter">
            <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="fashiondb" data-related="ipimax" data-lang="ru">Твитнуть</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
        </div>
        
        <div class="social-icon-google">
            <g:plusone size="medium"></g:plusone>
        </div>
        
        
        
        <br class="clearboth" />
        <?php /*
        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
        <div class="yashare-title">Поделиться</div>
        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div> 
        <br class="clearboth" />
         * */
         ?>
    </div>
    
    <div class="entry commententry">

            <h4 id="comments" class="entry-comments-header">Комментарии к посту "<?php echo CHtml::encode($model->title)?>"</h4>
            
            <?php if($model->commentCount>=1): ?>
                <?php $this->renderPartial('_comments',array(
                    'post'=>$model,
                    'comments'=>$model->comments,
                )); ?>
            <?php else:?>
                <p>Комментариев пока нет.</p>
            <?php endif; ?>

            <div id="respond">
                <h4 class="margin">Написать комментарий</h4>

                <?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
                    <div class="flash-success">
                        <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
                    </div>
                <?php else: ?>
                    <?php $this->renderPartial('_comment_form',array(
                        'model'=>$comment,
                    )); ?>
                <?php endif; ?>
            </div>
    </div>
</section>