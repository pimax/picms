<h3><a href="/wave/">Публикации</a></h3>

<div class="box box_small">
    <ul>
        <?php foreach ($this->getCategoriesCol(1) as $k => $itm):?>
            <li class="<?php if ($k == count($this->getCategoriesCol(1)) - 1):?>last<?php endif;?><?php if ($this->isItemActive('/wave/'.$itm->alias)):?> current<?php endif;?>"><a href="/wave/<?php echo $itm->alias?>"><?php echo $itm->title?></a></li>
        <?php endforeach;?>
    </ul>
</div><!--end box -->

<div class="box box_small">
    <ul>
        <?php foreach ($this->getCategoriesCol(2) as $k => $itm):?>
            <li class="<?php if ($k == count($this->getCategoriesCol(2)) - 1):?>last<?php endif;?><?php if ($this->isItemActive('/wave/'.$itm->alias)):?> current<?php endif;?>"><a href="/wave/<?php echo $itm->alias?>"><?php echo $itm->title?></a></li>
        <?php endforeach;?>
    </ul>
</div><!--end box -->