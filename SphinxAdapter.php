<?php
/**
 * Description of SphinxAdapter
 *
 * @author Slava Tutrinov
 */

class SphinxAdapter {

    public static function getSphinxKeywords($sQuery) {
        $aRequestString=preg_split('/[\s,-]+/', $sQuery, 5);
        if ($aRequestString) {
            foreach ($aRequestString as $sValue)
            {
                if (strlen($sValue)>=3)
                {
                    $aKeyword[] .= "(".$sValue." | *".$sValue."*)";
                }
            }
            $sSphinxKeyword = implode(" & ", $aKeyword);
        }
        return $sSphinxKeyword;
    }

}

?>
