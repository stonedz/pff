<?php

namespace pff\modules;

/**
 * Created by JetBrains PhpStorm.
 * User: alessandro
 * Date: 05/10/12
 * Time: 11.39
 * To change this template use File | Settings | File Templates.
 */
class Url extends \pff\AModule {

    public function clear_string($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public function make_url($id,$text){

        $result = $id . '-' . $this->clear_string($text);
        return $result;

    }

    public function get_id($text){

        $result = explode("-",$text);
        return $result[0];

    }
}
