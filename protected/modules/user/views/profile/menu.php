<ul class="ul-inline">
    <li><?php echo CHtml::link(UserModule::t('List User'), '/users'); ?></li>
    <li><?php echo CHtml::link(UserModule::t('Profile'),array('/user/profile')); ?></li>
    <li><?php echo CHtml::link(UserModule::t('Edit'),array('edit')); ?></li>
    <li><?php echo CHtml::link(UserModule::t('Change password'),array('changepassword')); ?></li>
    <li><?php echo CHtml::link(UserModule::t('Logout'),array('/user/logout')); ?></li>
</ul>