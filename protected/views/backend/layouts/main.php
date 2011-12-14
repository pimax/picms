<?php 
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!--[if lt IE 9]>
          <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5.js"></script>
        <![endif]-->

        <!-- Le styles -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-1.3.0.css" rel="stylesheet">
        
        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-dropdown.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-tabs.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-alerts.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-twipsy.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/permalink.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/translit.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
    </head>

    <body>

        <div class="topbar">
            <div class="container">
                <h3><a href="/admin/">picms</a></h3>
                
                <?php if (!Yii::app()->user->isGuest && UserModule::user()->superuser):?>
                    <ul class="nav">
                        <li<?php if (Yii::app()->request->getUrl() == '/admin/'):?> class="active"<?php endif;?>><?php echo CHtml::link('Главная', array('/')); ?></li>
                        <li<?php if (Yii::app()->request->getUrl() == '/admin/main/modulesItem/admin'):?> class="active"<?php endif;?>><?php echo CHtml::link('Управление модулями', array('/main/modulesItem/admin')); ?></li>
                        <li<?php if (Yii::app()->request->getUrl() == '/admin/main/options'):?> class="active"<?php endif;?>><?php echo CHtml::link('Общие настройки', array('/main/options')); ?></li>
                    </ul>
                    <ul class="nav secondary-nav">
                        <li class="dropdown">
                            <?php echo CHtml::link(UserModule::user()->profile->firstname.' '.UserModule::user()->profile->lastname.' ('.UserModule::user()->username.')', '#', array('class' => 'dropdown-toggle')); ?>
                            <ul class="dropdown-menu">
                                <li><?php echo CHtml::link('Профиль', array('/user/profile')); ?></li>
                                <li><?php echo CHtml::link('Настройки', array('/user/profile/edit')); ?></li>
                                <li><?php echo CHtml::link('Изменить пароль', array('/user/profile/changepassword')); ?></li>
                                <li class="divider"></li>
                                <li><?php echo CHtml::link('Выйти', array('/user/logout')); ?></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif;?>
            </div>
        </div>

        <div class="container">

            <div class="content">
                <div class="page-header">
                    <h1><?php echo $this->pageMainHeader?> <small><?php echo $this->pageMainHeaderDescription?></small></h1>
                </div>
                <div class="row">
                    <?php echo $content; ?>
                </div>
            </div>

            <footer>
                <p>Copyright &copy; <?php echo date('Y'); ?> by <a href="http://pimaxmedia.ru" target="_blank">pimaxmedia</a></p>
            </footer>

        </div> <!-- /container -->

    </body>
</html>