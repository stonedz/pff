<?php
/**
 * Main configuration file
 *
 * @author paolo.fagni<at>gmail.com
 */

/**
 * Set to true if in DEBUG mode
 */
$pffConfig['development_environment'] = true;

/**
 * Dafault controller action
 */
$pffConfig['default_action'] = 'index';


///////////////////////////////////////
// Database
///////////////////////////////////////

/**
 * Set to false if you DON'T WANT Doctrine ORM module to be loaded.
 */
$pffConfig['orm'] = true;

/**
 * Db connection data.
 */
$pffConfig['databaseConfig'] = array(
    'dbname' => '',
    'user' => '',
    'password' => '',
    'host' => '',
    'driver' => '',
);

/**
 * Db connection data if DEVELOPMENT_ENVIRONMENT is true
 */
$pffConfig['databaseConfigDev'] = array(
    'dbname' => '',
    'user' => '',
    'password' => '',
    'host' => '',
    'driver' => '',
);

///////////////////////////////////////
// Modules
///////////////////////////////////////

/**
 * Modules to be loaded
 */
$pffConfig['modules'] = array(
    'logger'
);

if(file_exists(ROOT .DS .'config' . DS . 'config.user.php')) {
    include (ROOT .DS .'config' . DS . 'config.user.php');
}