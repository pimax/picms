<?php 
$this->breadcrumbs=array(
	UserModule::t('Your profile'),
);

$this->pageMainHeader = UserModule::t("Profile");
$this->pageMainHeaderDescription = UserModule::t('Your profile');
$this->pageTitle = UserModule::t('Your profile');
?>
<section>
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<?php echo CHtml::button('Редактировать профиль', array('class' => 'btn success', 'onclick' => "location.href='".Yii::app()->createUrl('/user/profile/edit')."';"));?>
&nbsp;&nbsp;&nbsp;<?php echo CHtml::button('Изменить пароль', array('class' => 'btn info', 'onclick' => "location.href='".Yii::app()->createUrl('/user/profile/changepassword')."';"));?>
<br /><br />
<table class="VerticalTable">
<tr>
	<th class="labelTh"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
</th>
    <td><?php echo CHtml::encode($model->username); ?>
</td>
</tr>
<?php 
		$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo "<pre>"; print_r($profile); die();
			?>
<tr>
	<th class="labelTh"><?php echo CHtml::encode(UserModule::t($field->title)); ?>
</th>
    <td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?>
</td>
</tr>
			<?php
			}//$profile->getAttribute($field->varname)
		}
?>
<tr>
	<th class="labelTh"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>
</th>
    <td><?php echo CHtml::encode($model->email); ?>
</td>
</tr>
<tr>
	<th class="labelTh"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>
</th>
    <td><?php echo date("d.m.Y H:i:s",$model->createtime); ?>
</td>
</tr>
<tr>
	<th class="labelTh"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>
</th>
    <td><?php echo date("d.m.Y H:i:s",$model->lastvisit); ?>
</td>
</tr>
<tr>
	<th class="labelTh"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>
</th>
    <td><?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status));
    ?>
</td>
</tr>
</table>

</section>