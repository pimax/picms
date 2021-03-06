<?php 
$this->pageTitle = $model->getFullName(). ' - '.Yii::app()->getSite()->meta_title;
$profile = $model->profile;
?>
<section>
    <header>
        <h1><?php echo $model->getFullName(); ?></h1>
    </header>
    
    <div class="user-profile-photo">
        <?php if ($model->profile->avatar):?>
            <a rel="fancybox" href="<?php echo Pi::showImageUrl('/'.$model->profile->avatar)?>">
                <img src="<?php echo Pi::getThumbUrl('/'.$model->profile->avatar, 200)?>" alt="<?php echo $model->username?>" />
            </a>
        <?php else:?>
            <img src="<?php echo Yii::app()->params['uploadsImagesUrl']?>/nophoto.gif" alt="" />
        <?php endif;?>
    </div>
    
    <div class="user-profile-info">
        <table class="dataGrid">
            <tr>
                <th class="label">
                    <?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
                </th>
                <td>
                    <?php echo CHtml::encode($model->username); ?>
                </td>
            </tr>
        <?php 
                $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
                if ($profileFields) {
                    foreach($profileFields as $field) {?>
                        <?php if ($field->varname != 'avatar' && $profile->getAttribute($field->varname) && $profile->getAttribute($field->varname) != '0000-00-00'):?>
                            <tr>
                                <th class="label">
                                    <?php echo CHtml::encode(UserModule::t($field->title)); ?>
                                </th>
                                <td>
                                    <?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?>
                                </td>
                            </tr>
                        <?php endif;?>
                    <?php
                    }
                }
        ?>
        <tr>
            <th class="label">
                <?php echo CHtml::encode($model->getAttributeLabel('rating')); ?>
            </th>
            <td>
                <strong><?php echo CHtml::encode($model->rating); ?></strong>
            </td>
        </tr>
        <tr>
            <th class="label">
                <?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>
            </th>
            <td>
                <?php echo date("d.m.Y H:i:s", $model->createtime); ?>
            </td>
        </tr>
        <tr>
            <th class="label">
                <?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>
            </th>
            <td>
                <?php echo date("d.m.Y H:i:s", $model->lastactivity); ?>
            </td>
        </tr>
        </table>
    </div>
    <div class="clearboth"><!-- ~ --></div>
    

    

</section>