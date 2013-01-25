<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
require '../lib/autoload.php';
require '../app/autoload.php';
require '../app/config/config.user.php';

// Define application environment
define('APPLICATION_ENV', "development");

/*
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
*/

// configuration (2)
$config = new Doctrine\ORM\Configuration();

// Proxies (3)
$config->setProxyDir('../app/proxies');
$config->setProxyNamespace('pff\proxies');

$config->setAutoGenerateProxyClasses((APPLICATION_ENV == "development"));

// Driver (4)
$driverImpl = $config->newDefaultAnnotationDriver(array('../app/models'));
$config->setMetadataDriverImpl($driverImpl);

// Caching Configuration (5)
if (APPLICATION_ENV == "development") {

    $cache = new \Doctrine\Common\Cache\ArrayCache();

} else {

    $cache = new \Doctrine\Common\Cache\ApcCache();
}

$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

if ($pffConfig['development_environment'] == true) {
    $connectionOptions = $pffConfig['databaseConfigDev'];
} else {
    $connectionOptions = $pffConfig['databaseConfig'];
}


$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
