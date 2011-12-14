<?php

class StringHelper
{
	public static function replace($sSearch, $sReplace, $sSubject)
	{
		return str_replace($sSearch, $sReplace, $sSubject);
	}

    public static function substr($sString, $nStart = 0, $nMaxLen = 250)
	{
        $sString = strip_tags($sString);
        $sString = mb_substr($sString, $nStart, $nMaxLen, "utf8");
        
        $nPos = max(mb_strrpos($sString, ',', "utf8"), mb_strrpos($sString, '.', "utf8"), mb_strrpos($sString, '!', "utf8"), mb_strrpos($sString, '?', "utf8"), mb_strrpos($sString, ' ', "utf8"));
        $sString = mb_substr($sString, 0, $nPos, "utf8");
        //echo $nPos, ':', mb_strlen($sString, "utf8");
        if (mb_strrpos($sString, ',', "utf8") == mb_strlen($sString, "utf8") - 1 || mb_strrpos($sString, '.', "utf8") == mb_strlen($sString, "utf8") - 1 || mb_strrpos($sString, '!', "utf8") == mb_strlen($sString, "utf8") - 1 || mb_strrpos($sString, '?', "utf8") == mb_strlen($sString, "utf8") - 1) {
            $sString = mb_substr($sString, 0, mb_strlen($sString, "utf8") - 1, "utf8");
        }
        
        return $sString.'...';
        //$sString = mb_substr($sString, 0, mb_strrpos(mb_substr($sString, $nStart, $nMaxLen, "utf8"), ' ', "utf8"), "utf8" ).'...';
        
        //echo mb_strrpos(mb_substr($sString, $nStart, $nMaxLen, "utf8"), ',', "utf8");
		/*$aEndWords = array('.', '!', '?', ' ');

		$nLen = mb_strlen($sString, "utf8");
		if ($nLen <= $nMaxLen) {
			return $sString;
		} else {
			for ($i = $nMaxLen - 1; $i > 0; $i--) {
				if (in_array($sString{$i}, $aEndWords) !== false) {
					return mb_substr($sString, $nStart, $i, 'utf8').'...';
				}
			}

			return $sString;
		}*/
	}

    public function translit($sString)
    {
        $sString = strtr($sString,"абвгдеёзийклмнопрстуфхъыэ_", "abvgdeeziyklmnoprstufh'iei");

        $sString = strtr($sString,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_", "ABVGDEEZIYKLMNOPRSTUFH'IEI");

        $sString = strtr($sString,
            array(
                "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
                "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
                "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
            )
        );

        return $sString;
    }
}