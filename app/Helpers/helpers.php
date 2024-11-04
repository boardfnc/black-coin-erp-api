<?php
if (! function_exists('randStrCapital')) {
    function randStrCapital($len)
    {
        $return_str = "";
        for ( $i = 0; $i < $len; $i++ ){
            mt_srand((double)microtime()*1000000);
            $return_str .= substr('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(0,35), 1);
        }
        return $return_str;
    }
}

