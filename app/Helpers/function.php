<?php
if(!function_exists('firstwords')) {
    function firstwords($s, $limit=3) {
        return preg_replace('/((\w+\W*){'.($limit-1).'}(\w+))(.*)/', '${1}', $s);
    }
}

if(!function_exists('firstwords_2')) {
    function firstwords_2($s, $limit=3) {
        $string = strip_tags($s);
        if (strlen($string) > $limit) {

            // truncate string
            $stringCut = substr($string, 0, $limit);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }

        return $string;
    }
}
