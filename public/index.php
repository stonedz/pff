<?php
/**
 * Front controller
 *
 * @author paolo.fagni<at>gmail.com
 * @category lib
 * @version 0.1
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__. DS . '..');
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$ext_root =  $protocol . "://" . $_SERVER['HTTP_HOST'].'/';

define('EXT_ROOT', $ext_root);

(isset($_GET['url'])) ? $url = $_GET['url'] : $url='' ;

require_once(ROOT . DS . 'lib' . DS . 'bootstrap.php');

