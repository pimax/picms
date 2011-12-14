<?php

class CmsApplication extends CWebApplication
{
    protected $site = false;
    
    protected $page = false;
    
    public function processRequest()
	{
		if(is_array($this->catchAllRequest) && isset($this->catchAllRequest[0]))
		{
			$route=$this->catchAllRequest[0];
			foreach(array_splice($this->catchAllRequest,1) as $name=>$value)
				$_GET[$name]=$value;
		}
		else {
			$route=$this->getUrlManager()->parseUrl($this->getRequest());
        }
        
        //echo '<pre>', print_r($this->getRequest()->getUrl(), true), '</pre>';
        
        if ($this->getRequest()->getUrl() != '/' && mb_strrpos($this->getRequest()->getUrl(), "/", 0, "utf8") === mb_strlen($this->getRequest()->getUrl(), "utf8") - 1) {
            $this->getRequest()->redirect(mb_substr($this->getRequest()->getUrl(), 0, mb_strlen($this->getRequest()->getUrl(), "utf8") - 1, "utf8"), true, 301);
        }
        
        Yii::import('application.modules.main.*');
        Yii::import('application.modules.main.models.*');
        Yii::import('application.modules.main.components.*');
        Yii::import('application.modules.structure.*');
        Yii::import('application.modules.structure.models.*');
        Yii::import('application.modules.structure.components.*');
        
        $this->findSite();
        $this->findPage($route);
        
        if ($this->getPage()) {
            
            if ($this->getPage()->type_id == 1) {
                // simple page
                if ($this->getPage()->path == '/'.$route) {
                    $sRoute = $this->getPage()->type->module->module_alias.'/'.$this->getPage()->type->controller_alias.'/'.$this->getPage()->type->action_alias;
                } else {
                    $sRoute = $route;
                }
            } else {
                // other page types
                $sRoute = $this->getPage()->type->module->module_alias.'/'.$this->getPage()->type->controller_alias.'/'.$this->getPage()->type->action_alias;
                if ($this->getPage()->path != '/'.$route) {
                    $_GET['path'] = str_replace($this->page->path.'/', "", '/'.$route);
                    if (isset($_GET['id'])) {
                        $_GET['path'] .= '/'.$_GET['id'];
                        unset($_GET['id']);
                    }
                }
            }     
                      
        } else {
            $this->page = new Page();
            //$this->findPage("/");
            //if ($this->getPage()->type_id == 1) {
                $sRoute = $route;
            //} else {
            //    $sRoute = $this->getPage()->type->module->module_alias.'/'.$this->getPage()->type->controller_alias.'/'.$this->getPage()->type->action_alias;
            //}
        }
        
        $this->runController($sRoute);
             
	}
    
    public function getSite()
    {
        return $this->site;
    }
    
    public function getPage()
    {
        return $this->page;
    }
    
    protected function findSite()
    {
        if ($this->site = Site::model()->find("url = :url", array(':url'=> $this->getRequest()->getServerName())))
        {                        
            return true;
        }
        
        return false;
    }
    
    protected function findPage($route)
    {
        if ($route === "") {
            // main page
            
            $this->page = Page::model()->findByPk(1);
            
            return true;
            
        } else {
            $aRoute = explode("/", $route);
            
            if (count($aRoute) <= 10) {            
                for ($i = 0; $i < count($aRoute); $i++) {
                    $sUrl = '';
                    for ($n = 0; $n < count($aRoute) - $i; $n++) {
                        $sUrl .= '/'.$aRoute[$n];
                    }    

                    if ($this->page = Page::model()->find("path = :path and site_id = :site_id", array(":path" => $sUrl, ":site_id" => $this->getSite()->id))) {
                        return true;
                    }                
                }
            }
        }
        
        return false;
    }
}