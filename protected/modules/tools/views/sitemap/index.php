<?php
$this->breadcrumbs=array(
	Tools::t('Google.Sitemap'),
);
$this->pageMainHeader = Tools::t('Google.Sitemap');
$this->pageMainHeaderDescription = Tools::t('generator');
?>
<?php echo CHtml::button('Сгенерировать', array('class' => 'btn success', 'onclick' => "location.href='".Yii::app()->createUrl('/tools/sitemap/generate')."';"));?>
<br /><br />
<?php if ($sitemap_exists):?>
    <div class="alert-message">
        <p>Карта сайта сгенерирована <?php echo $sitemap_date?>. <a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']?>/sitemap.xml">Посмотреть</a></p>
    </div>
<?php else:?>
    <div class="alert-message error">
        <p>Карта сайта не создана.</p>
    </div>
<?php endif; ?>