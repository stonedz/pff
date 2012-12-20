<?php

if (!function_exists("phpr_getImageName")){

    function phpr_getImageName($json){

       $arr = json_decode($json);
       $path_parts = pathinfo($arr[0]->name);
       $value = $path_parts['filename'] . '.' . $path_parts['extension'];
       return $value;

    }

}
