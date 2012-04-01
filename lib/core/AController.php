<?php

namespace pff;

use \Doctrine\ORM\EntityManager,
    \Doctrine\ORM\Configuration;

/**
 * Every controller must implement this abstract class
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AController {

    /**
     * @var string
     */
    protected $_controllerName;

    /**
     * @var string
     */
    protected $_action;

    /**
     * @var \pff\AView
     */
    protected $_view;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $_em;

    /**
     * Creates a controller
     *
     * @param string $controllerName The controller's name (used to load correct model)
     * @param string $action Action to perform
     */
    public function __construct($controllerName, $action = 'index') {
        $this->_controllerName = $controllerName;
        $this->_action = $action;

        if (DEVELOPMENT_ENVIRONMENT == 1) {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }

        $config = new Configuration;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(ROOT . DS . 'app' . DS . 'models');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(ROOT . DS  .'app' . DS . 'proxies');
        $config->setProxyNamespace('pff\proxies');

        if (DEVELOPMENT_ENVIRONMENT == 1) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        $connectionOptions = array(
            'dbname' => 'testDb',
            'user' => 'root',
            'password' => 'TYte2006',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );

        $this->_em = EntityManager::create($connectionOptions, $config);

    }

    /**
     * Method executed before the action
     */
    public function beforeAction() {
    }

    /**
     * Method executed after the action
     */
    public function afterAction() {
    }

    /**
     * Called before the controller is deleted.
     *
     * The view's render method is called.
     */
    public function __destruct() {
        if (isset($this->_view)) {
            $this->_view->render();
        }
    }

    /**
     * All controllers should at least implement an index
     *
     * @abstract
     * @return mixed
     */
    abstract public function index();
}
