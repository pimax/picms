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
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-simple">

            <div class="content">
                <div class="page-header">
                    <h1><?php echo CHtml::link($this->pageMainHeader, array('/'));?> <small><?php echo $this->pageMainHeaderDescription?></small></h1>
                </div>
                <div class="row">
                    <div class="span7">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>

        </div> <!-- /container -->
    </body>
</html>