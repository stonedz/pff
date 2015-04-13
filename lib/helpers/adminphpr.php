<?php
/**
 * Helpers for PHPRuner
 */

if (!function_exists("phpr_getImageName")){
    /**
     * Gets the image filename
     *
     * @param string $json
     * @return string
     */
    function phpr_getImageName($json) {
        $arr        = json_decode($json);
        $path_parts = pathinfo($arr[0]->name);

        $value = $path_parts['filename'] . '.' . $path_parts['extension'];
        return $value;
    }
}

if (!function_exists("phpr_getThumbName")){
  /**
   * Gets the thumbnail filename
   *
   * @param string $json
   * @return string
   */
  function phpr_getThumbName($json) {
    $value = "";
    $arr = json_decode($json);
    if(property_exists($arr[0],"thumbnail")){
      $path_parts = pathinfo($arr[0]->thumbnail);
      $value = $path_parts['filename'] . '.' . $path_parts['extension'];
    }
    return $value;
  }
}

if (!function_exists("phpr_getPdfName")){
    /**
     * Gets the pdf filename
     *
     * @param string $json
     * @return string
     */
    function phpr_getPdfName($json) {
        $arr        = json_decode($json);
        $path_parts = pathinfo($arr[0]->name);

        $value = $path_parts['filename'] . '.' . $path_parts['extension'];
        return $value;
    }
}
