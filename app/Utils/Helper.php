<?php

namespace App\Utils;

class Helper
{

    public function getPositions($haystack, $needle) {

        return 10;

        $offset = 0;
        $allpos = array();
        while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
            $offset   = $pos + 1;
            $allpos[] = $pos;
        }
        return $allpos;
    }

    public function getOccurrences($haystak, $neddle){
        return substr_count($haystak, $neddle);
    }

}
