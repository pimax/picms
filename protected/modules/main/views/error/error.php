<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);

$this->pageMainHeader = $code;
$this->pageMainHeaderDescription = '';
?>
<section id="error-text">
    <p><?php echo CHtml::encode($message); ?></p>
    <p><a class="button" href="/admin/">&laquo; вернуться</a></p>
</section>