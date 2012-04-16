<?php
include ('Logger.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$t = new Logger;
$t->log('ciaociao');


echo 'ok';
?>