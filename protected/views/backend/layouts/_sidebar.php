<?php if (!Yii::app()->user->isGuest && UserModule::user()->superuser):?>
    <h5>Структура</h5>
    <ul>
        <li><?php echo CHtml::link('Управление страницами', array('/structure/page/admin')); ?></li>
        <li><?php echo CHtml::link('Настройки сайта', array('/structure/site/update/id/1')); ?></li>
        <li><?php echo CHtml::link('Управление шаблонами', array('/structure/template/admin')); ?></li>
        <li><?php echo CHtml::link('Тип контента', array('/structure/structureType/admin')); ?></li>
    </ul>

    <h5>Публикации</h5>
    <ul>
        <li><?php echo CHtml::link('Управление публикациями', array('/publications/publicationsPost/admin')); ?></li>
        <li><?php echo CHtml::link('Управление категориями', array('/publications/publicationsCategory/admin')); ?></li>
        <li><?php echo CHtml::link('Управление комментариями', array('/publications/publicationsComment/admin')); ?></li>
    </ul>

    <h5>Пользователи</h5>
    <ul>
        <li><?php echo CHtml::link('Управление пользователями', array('/user/admin')); ?></li>
        <li><?php echo CHtml::link('Настройка полей', array('/user/profileField')); ?></li>
        <li><?php echo CHtml::link('Настройка прав доступа', array('/rights')); ?></li>
    </ul>

    <h5>Инструменты</h5>
    <ul>
        <li><?php echo CHtml::link('Файловый менеджер', array('/tools/fmanager')); ?></li>
        <li><?php echo CHtml::link('Google.Sitemap', array('/tools/sitemap')); ?></li>
    </ul>
<?php endif;?>