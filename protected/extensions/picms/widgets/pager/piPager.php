<?php

class piPager extends CLinkPager
{
    public $header = '';
    
    public $prevPageLabel = '← Предыдущая';
    
    public $nextPageLabel = 'Следующая →';
    
    public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','Next &gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt; Previous');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt; First');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','Last &gt;&gt;');
		if($this->header===null)
			$this->header=Yii::t('yii','Go to page: ');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='';
	}
    
    /**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
        if(($pageCount=$this->getPageCount())<=1)
                return;
        
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
        
        $currentPage=$this->getCurrentPage(false); 
        
        echo '<section class="pagination">';
		echo $this->header;
        
        // prev page
		if(($page=$currentPage-1)<0) $page=0;
        $sClass = 'plink prev';
        if ($currentPage<=0) $sClass .= ' hidden';
        echo CHtml::link($this->prevPageLabel, $this->createPageUrl($page), array('class' => $sClass));       
        
        
		echo CHtml::tag('div', array(), CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons)));
        
        
        if(($page=$currentPage+1)>=$pageCount-1) $page=$pageCount-1;
        $sClass = 'pnlink next';
        if ($currentPage>=$pageCount-1) $sClass .= ' hidden';
        echo CHtml::link($this->nextPageLabel, $this->createPageUrl($page), array('class' => $sClass)); 
        
		echo $this->footer;
        echo '</section>';
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		//$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// prev page
		/*if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);*/

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

		// next page
		/*if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);*/

		return $buttons;
	}
    
    /**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
        
        if ($selected) {
            return '<span>'.$label.'</span>';
        } else {
            return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
        }
	}
    
    /**
	 * Creates the URL suitable for pagination.
	 * @param integer $page the page that the URL should point to.
	 * @return string the created URL
	 * @see CPagination::createPageUrl
	 */
	protected function createPageUrl($page)
	{
		return $this->getPages()->createPageUrl($this->getController(),$page);
	}
    
    /**
	 * Creates the default pagination.
	 * This is called by {@link getPages} when the pagination is not set before.
	 * @return CPagination the default pagination instance.
	 */
	protected function createPages()
	{
		return new piPagination;
	}
}