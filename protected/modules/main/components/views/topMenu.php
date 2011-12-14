<ul class="catnav">
    <li<?php if ($this->isItemActive('/wave/trends')):?> class="current"<?php endif;?>><a href="/wave/trends"><strong>Модные тенденции</strong></a></li>
    <li<?php if ($this->isItemActive('/wave/style')):?> class="current"<?php endif;?>><a href="/wave/style"><strong>Стиль</strong></a></li>
    <li<?php if ($this->isItemActive('/wave/man')):?> class="current"<?php endif;?>><a href="/wave/man"><strong>Мужская мода</strong></a></li>
    <li<?php if ($this->isItemActive('/wave/hairstyle')):?> class="current"<?php endif;?>><a href="/wave/hairstyle"><strong>Прически</strong></a></li>
    <li<?php if ($this->isItemActive('/wave/beauty')):?> class="current"<?php endif;?>><a href="/wave/beauty"><strong>Красота и здоровье</strong></a></li>
    <li<?php if ($this->isItemActive('/wave/designers')):?> class="current"<?php endif;?>><a href="/wave/designers"><strong>Дизайнеры</strong></a></li>
    <li class="dropdown">
        <a href="javascript:void(0)"><strong>Все потоки</strong></a>
        <div class="dropdown-menu-box">
            <ul class="dropdown-list">
                <?php foreach ($this->getCategoriesCol(1) as $k => $itm):?>
                    <li class="<?php if ($k == count($this->getCategoriesCol(1)) - 1):?>last<?php endif;?><?php if ($this->isItemActive('/wave/'.$itm->alias)):?> current<?php endif;?>"><a href="/wave/<?php echo $itm->alias?>"><?php echo $itm->title?></a></li>
                <?php endforeach;?>
            </ul>
            <ul class="dropdown-list">
                <?php foreach ($this->getCategoriesCol(2) as $k => $itm):?>
                    <li class="<?php if ($k == count($this->getCategoriesCol(2)) - 1):?>last<?php endif;?><?php if ($this->isItemActive('/wave/'.$itm->alias)):?> current<?php endif;?>"><a href="/wave/<?php echo $itm->alias?>"><?php echo $itm->title?></a></li>
                <?php endforeach;?>
            </ul>
            <div class="clearboth"><!-- ~ --></div>
        </div>
    </li>
</ul><!-- end catnav-->