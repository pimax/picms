<?php

Yii::import('zii.widgets.grid.CDataColumn');

class CmsDataGridColumn extends CDataColumn
{
    public $headerHtmlOptions = array('class' => 'header blue');
    
    /**
	 * Renders the header cell.
	 */
	public function renderHeaderCell()
	{
        $directions=$this->grid->dataProvider->getSort()->getDirections();
        $htmlOptions = array();
		if(isset($directions[$this->name]))
		{
			$class=$directions[$this->name] ? 'headerSortUp' : 'headerSortDown';
			if(isset($this->headerHtmlOptions['class']))
				$this->headerHtmlOptions['class'].=' '.$class;
			else
				$this->headerHtmlOptions['class']=$class;
		}
        
        
		$this->headerHtmlOptions['id']=$this->id;
		echo CHtml::openTag('th',$this->headerHtmlOptions);
		$this->renderHeaderCellContent();
		echo "</th>";
	}
    
    /**
	 * Renders the header cell content.
	 * This method will render a link that can trigger the sorting if the column is sortable.
	 */
	protected function renderHeaderCellContent()
	{
        //echo '<pre>', print_r($this->grid->dataProvider->getSort(), true), '</pre>';
		if($this->grid->enableSorting && $this->sortable && $this->name!==null) {
			echo $this->grid->dataProvider->getSort()->link($this->name,$this->header);
        }
		else if($this->name!==null && $this->header===null)
		{
			if($this->grid->dataProvider instanceof CActiveDataProvider)
				echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
			else
				echo CHtml::encode($this->name);
		}
		else
			parent::renderHeaderCellContent();
	}
}