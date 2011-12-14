<?php

class SitemapController extends BackEndController
{
    protected $_xml;
    protected $_url_counter;
    
	public function actionIndex()
	{
        $sPath = Yii::app()->basePath.'/../sitemap.xml';
        
        $sitemap_exists = file_exists($sPath);
        
		$this->render('index', array(
            'sitemap_exists' => $sitemap_exists,
            'sitemap_date' => $sitemap_exists ? Pi::showDateTime(filemtime($sPath)) : false
        ));
	}
    
    public function actionGenerate()
    {
        $aLinks = array();
        
        Yii::import('application.modules.structure.models.*');
        Yii::import('application.modules.publications.models.*');
        Yii::import('application.modules.users.models.*');
        
        $aItems = Page::model()->findAll(array('order'=>'lft', 'condition' => 'show_in_sitemap = 1'));        
        if (count($aItems)) {
            foreach ($aItems as $itm) {
                $aLinks[] = array(
                    'loc' => 'http://'.$_SERVER['HTTP_HOST'].$itm->path,
                    'lastmod' => $itm->update_time,
                    'changefreq' => $itm->path == "/" ? "Daily" : "Weekly",
                    'priority' => $itm->path == "/" ? 1 : 0.6
                );
            }
        }
        
        $aItems = PublicationsPost::model()->findAll(array('condition' => 'status = '.PublicationsPost::STATUS_PUBLISHED, 'order' => 'post_date'));        
        if (count($aItems)) {
            foreach ($aItems as $itm) {
                $aLinks[] = array(
                    'loc' => 'http://'.$_SERVER['HTTP_HOST'].$itm->getUrl(true),
                    'lastmod' => $itm->update_time,
                    'changefreq' => "Monthly",
                    'priority' => 0.2
                );
            }
        }
        
        $aItems = User::model()->findAll(array('condition' => 'status = 1', 'order' => 'createtime'));        
        if (count($aItems)) {
            foreach ($aItems as $itm) {
                $aLinks[] = array(
                    'loc' => 'http://'.$_SERVER['HTTP_HOST'].$itm->getUrl(),
                    'lastmod' => $itm->lastvisit,
                    'changefreq' => "Monthly",
                    'priority' => 0.2
                );
            }
        }
        
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <?xml-stylesheet type="text/xsl" href="http://'.$_SERVER['HTTP_HOST'].'/sitemap.xsl"?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                 xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
                 xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        </urlset>';
        
        $this->_xml = new SimpleXMLElement($xml);
        
        if (count($aLinks)) {
            foreach ($aLinks as $itm) {
                $this->addUrl($itm['loc'], $itm['lastmod'], $itm['changefreq'], $itm['priority']);
            }
            
            $sPath = Yii::app()->basePath.'/../sitemap.xml';
            
            if (file_exists($sPath)) {
                unlink($sPath);
            }
            
            file_put_contents($sPath, $this->_xml->asXML());
        }
        
        $this->redirect(array('index'));
    }
    
    private function addUrl($loc, $lastmod, $changefreq = "monthly", $priority = 0.8)
    {
        /* 
         * Max urls per file: 
         * http://www.sitemaps.org/faq.php#faq_sitemap_size
         */
        if ($this->_url_counter >= 50000) {
            throw new Exception('URLs quantity limit per sitemap file exceeded.');
        }
        
        $xmlurl=$this->_xml->addChild('url');
        $xmlurl->addChild('loc',CHtml::encode($loc));
        $xmlurl->addChild('lastmod',$this->formatDatetime($lastmod));
        $xmlurl->addChild('changefreq',$changefreq);
        $xmlurl->addChild('priority',$priority);
        $this->_url_counter++;
        
        return true;
    }
    
    /**
	 * Formats given date to W3C datetime format
	 * @param mixed $val
	 * @return string 
	 */
	private function formatDatetime($val)
	{
        $result = false;
        if (is_numeric($val)) {
            $result = date("Y-m-d\TH:i:sP", $val);
        } elseif (is_string($val)) {
            $result = date("Y-m-d\TH:i:sP", strtotime($val));
        }
        
		return $result;
	}
}