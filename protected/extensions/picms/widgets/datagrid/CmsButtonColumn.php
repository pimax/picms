<?php
Yii::import('zii.widgets.grid.CButtonColumn');

class CmsButtonColumn extends CButtonColumn
{
    public $template = '{update} {delete}';
}