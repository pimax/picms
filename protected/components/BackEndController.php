<?php

class BackEndController extends Controller 
{
    public $layout = '//layouts/admin';

    public $menu = array();

    public $breadcrumbs = array();
    
    public $pageMainHeader = '';
    public $pageMainHeaderDescription = '';
    
    public function init()
    {
        
    }
   
    public function filters() 
    {
        return array(
            'rights',
        );
    }

}