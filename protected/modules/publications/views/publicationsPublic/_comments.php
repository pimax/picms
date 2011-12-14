<!-- comment-->
    <?php foreach($comments as $k => $comment): ?>
        <?php 
            $sClass = "odd";
            if ($k % 2 == 0) $sClass = "even";
            $level = $comment->level >= 3 ? 3 : $comment->level;
        ?>
        <div id="comment_<?php echo $comment->id?>" class="comment <?php echo $sClass?> thread-<?php echo $sClass?> depth-<?php echo $level?>">
            <div class="info">
                <div class="folding-dot-holder"><div class="folding-dot"></div></div>

                <div class="voting" id="voting_4349462">

                    <div class="plus" id="comment_<?php echo $comment->id?>_rating_plus">
                        <?php if ($comment->checkUserRating()):?><?php echo CHtml::ajaxLink('+', '/wave/comment_rate', array('data' => array('id' => $comment->id, 'type' => 1), 'type' => 'post', 'success' => 'FDB.AJAX.rateCommentSuccess'))?><?php else:?>+<?php endif;?>
                    </div>
                    
                    <div class="mark">
                        <span class="score" id="comment_<?php echo $comment->id?>_rating"><?php echo $comment->rating?></span> 
                    </div>  
                    <div class="minus" id="comment_<?php echo $comment->id?>_rating_minus">
                        <?php if ($comment->checkUserRating()):?><?php echo CHtml::ajaxLink('-', '/wave/comment_rate', array('data' => array('id' => $comment->id, 'type' => 2), 'type' => 'post', 'success' => 'FDB.AJAX.rateCommentSuccess'))?><?php else:?>-<?php endif;?>
                    </div>
                </div>

                <?php if ($comment->author->profile->avatar):?>
                    <a class="avatar" href="/users/<?php echo $comment->author->username?>"><img src="<?php echo Pi::getThumbUrl('/'.$comment->author->profile->avatar, 24, true)?>" /></a>
                <?php else:?>
                    <a class="avatar" href="/users/<?php echo $comment->author->username?>"><img src="<?php echo Yii::app()->params['uploadsImagesUrl']; ?>/no_photo_24.png" alt="" /></a>
                <?php endif;?>
                <a class="username" href="/users/<?php echo $comment->author->username?>"><?php echo $comment->author->username?></a>
                <div class="time"><?php echo Pi::showDateTime($comment->create_time)?></div>
                <a class="link_to_comment" href="#comment_<?php echo $comment->id?>">#</a>

                <div class="clearboth"></div>
            </div>
            <div class="message">
                <?php echo nl2br(CHtml::encode($comment->content)); ?>
            </div>
            <div class="reply">
                <a onclick="FDB.UTILS.reply_comment('<?php echo $comment->id; ?>')" class="reply" href="javascript:void(0)" style="display: inline;">ответить</a>
            </div>
            <div class="reply_form" id="comment_reply_<?php echo $comment->id; ?>"></div>
        </div>
    <?php endforeach; ?>
<br class="clearboth" />