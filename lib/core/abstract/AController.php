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
     * @var \pff\AView[]
     */
    protected $_view;

    /**
     * @var \pff\Config
     */
    protected $_config;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $_em;

    /**
     * Creates a controller
     *
     * @param string $controllerName The controller's name (used to load correct model)
     * @param \pff\Config $cfg App configuration
     * @param string $action Action to perform
     */
    public function __construct($controllerName, \pff\Config $cfg, $action = 'index') {
        $this->_controllerName = $controllerName;
        $this->_action         = $action;
        $this->_config         = $cfg;

        if($this->_config->getConfig('orm')) {
            $this->initORM();
        }
    }

    /**
     * Initializes Doctrine entity manager
     */
    private function initORM() {

        if ($this->_config->getConfig('development_environment') == true) {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }

        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(ROOT . DS . 'app' . DS . 'models');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(ROOT . DS  .'app' . DS . 'proxies');
        $config->setProxyNamespace('pff\proxies');

        if ($this->_config->getConfig('development_environment') == true) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        $connectionOptions = $this->_config->getConfig('databaseConfig');

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
     * Adds a view
     *
     * @param \pff\AView $view
     */
    public function addView(\pff\AView $view) {
        $this->_view[] = $view;
    }

    /**
     * Called before the controller is deleted.
     *
     * The view's render method is called for each view registered.
     *
     * @throws \pff\ViewException
     */
    public function __destruct() {
        if (isset($this->_view)) {
            if(is_array($this->_view)) {
                foreach($this->_view as $view) {
                   $view->render();
                }
            }
            elseif(is_a($this->_view, '\\pff\\AView')) {
                $this->_view->render();
            }
            else {
                throw new \pff\ViewException("The view specified is not valid.");
            }
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
