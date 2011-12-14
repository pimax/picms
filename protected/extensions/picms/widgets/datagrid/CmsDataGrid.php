<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('ext.picms.widgets.datagrid.CmsDataGridButton');
Yii::import('ext.picms.widgets.datagrid.CmsDataGridColumn');


class CmsDataGrid extends CGridView
{
    public $template = '{buttons}{items}{pager}';
    
    public $itemsCssClass = 'table';
    
    public $htmlOptions = array('class' => 'zebra-striped');
    
    public $headerHtmlOptions = array('class' => 'blue header');
    
    public $pager = array('header' => '');
    
    public $buttons = array();
    
    public function renderButtons()
    {
        if (is_array($this->buttons) && count($this->buttons)) {
            echo '<div class="top">';
            foreach ($this->buttons as $itm) {
                $this->widget('CmsDataGridButton', $itm);
            } 
            echo '</div>';
        }
    }
}