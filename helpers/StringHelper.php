<?php

namespace linchpinstudios\filemanager\helpers;

use Yii;

class StringHelper extends \yii\helpers\StringHelper
{


    /**
     * Generate a clean slug form a string
     * @param string $str       Input string to convert to slug
     * @param array  $replace   Charactures that should be replaced with a space
     * @param string $delimiter Deleminator to separate words and special characters
     */
    static public function genSlug($str, $replace = [], $delimiter = '-'){

    	if( !empty($replace) ) {
    		$str = str_replace((array)$replace, ' ', $str);
    	}

    	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    	$clean = strtolower(trim($clean, '-'));
    	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    	return $clean;

    }

}
