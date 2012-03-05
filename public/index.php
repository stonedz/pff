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

$url = $_GET['url'];

require_once(ROOT . DS . 'lib' . DS . 'bootstrap.php');

