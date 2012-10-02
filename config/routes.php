<?php
/**
 * Define routes here.
 *
 * @author paolo.fagni<at>gmail.com
 */


if(file_exists(ROOT .DS .'app' . DS .'config' .DS. 'routes.user.php')) {
    include (ROOT .DS .'app' . DS . 'config' .DS.'routes.user.php');
}

