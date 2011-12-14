<?php

class Pi
{
    public static $aMonth = array(
        0 => "",
        1 => "января",
        2 => "февраля",
        3 => "марта",
        4 => "апреля",
        5 => "мая",
        6 => "июня",
        7 => "июля",
        8 => "августа",
        9 => "сентября",
        10 => "октября",
        11 => "ноября",
        12 => "декабря",
    );
    
    public static function showDate($sTime = false)
    {
        if (!$sTime) {
            $sTime = time();
        } else {
            if (!is_numeric($sTime)) {
                $sTime = strtotime($sTime);
            }
        }
        
        if (date("d.m.Y", $sTime) == date("d.m.Y")) {
            $sDate = 'сегодня';
        } else if (date("d.m.Y", $sTime) == date("d.m.Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")))) {
            $sDate = 'вчера';
        } else {
            $sDate = (int)date("d", $sTime)." ".self::$aMonth[(int)date("m", $sTime)]." ".date("Y", $sTime);
        }
        
        return $sDate;
    }
    
    public static function showDateTime($sTime = false)
    {
        if (!$sTime) {
            $sTime = time();
        }
        
        return self::showDate($sTime)." в ".date("H:i", $sTime);
    }
    
    public static function showImageUrl($sPath)
    {
        $sFullPath = Yii::app()->params['uploadsImagesPath'].$sPath;
        
        if (file_exists($sFullPath)) {
            $sNewName = $sPath;
        } else {
            $sNewName = '/not_found.jpg';
        }
        
        return Yii::app()->params['uploadsImagesUrl'].$sNewName;
    }
    
    public static function getThumbUrl($sPath, $nWidth, $square = false)
    {
        $sFullPath = Yii::app()->params['uploadsImagesPath'].$sPath;
        
        if (file_exists($sFullPath)) {
            if ($square) {
                $sNewName = str_replace(".".pathinfo($sPath, PATHINFO_EXTENSION), "_".$nWidth."x".$nWidth.".".pathinfo($sPath, PATHINFO_EXTENSION), $sPath);
            } else {
                $sNewName = str_replace(".".pathinfo($sPath, PATHINFO_EXTENSION), "_".$nWidth.".".pathinfo($sPath, PATHINFO_EXTENSION), $sPath);
            }
            if (!file_exists(Yii::app()->params['uploadsImagesPath'].$sNewName)) {        
                $img = Yii::app()->simpleImage->load($sFullPath);
                if ($square) {
                    $img->crop($nWidth, $nWidth);
                } else {
                    $img->resizeToWidth($nWidth);
                }
                $img->save(Yii::app()->params['uploadsImagesPath'].$sNewName);
            }

            return Yii::app()->params['uploadsImagesUrl'].$sNewName;
        }
        
        return false;
    }
    
    
    public static function name()
    {
        return 'picms';
    }
    
    public static function version()
    {
        return '0.1 alpha';
    }
    
    public static function powered()
    {
        return 'Powered by <a href="http://picms.ru/" target="_blank">'.self::name().'</a>'.' '.self::version(); 
    }
}