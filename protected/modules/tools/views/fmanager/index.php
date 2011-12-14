<?php
$this->breadcrumbs=array(
	Tools::t('File manager'),
);
$this->pageMainHeader = Tools::t('File manager');
?>
<?php $this->widget('application.extensions.elFinder.elFinder', array());?>