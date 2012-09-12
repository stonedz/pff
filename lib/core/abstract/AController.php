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
     * The app that is running
     *
     * @var \pff\App
     */
    protected $_app;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $_em;

    /**
     * Array of parameters passed to the specified action
     *
     * @var array
     */
    protected $_params;

    /**
     * Creates a controller
     *
     * @param string $controllerName The controller's name (used to load correct model)
     * @param \pff\App $app
     * @param string $action Action to perform
     * @param array $params An array with parameters passed to the action
     * @internal param \pff\Config $cfg App configuration
     */
    public function __construct($controllerName, \pff\App $app, $action = 'index', $params=array()) {
        $this->_controllerName = $controllerName;
        $this->_action         = $action;
        $this->_app            = $app;
        $this->_config         = $app->getConfig(); //Even if we have an \pff\App reference we keep this for legacy reasons.
        $this->_params         = $params;

        if($this->_config->getConfigData('orm')) {
            $this->initORM();
        }
    }

    /**
     * Initializes Doctrine entity manager
     */
    private function initORM() {

        if ($this->_config->getConfigData('development_environment') == true) {
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

        if ($this->_config->getConfigData('development_environment') == true) {
            $config->setAutoGenerateProxyClasses(true);
            $connectionOptions = $this->_config->getConfigData('databaseConfigDev');
        } else {
            $config->setAutoGenerateProxyClasses(false);
            $connectionOptions = $this->_config->getConfigData('databaseConfig');
        }


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
     * Adds a view at the top of the stack
     *
     * @param AView $view
     */
    public function addViewPre(\pff\AView $view) {
        array_unshift($this->_view, $view);
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
                $this->_app->getHookManager()->runBeforeView();
                foreach($this->_view as $view) {
                    $view->render();
                }
                $this->_app->getHookManager()->runAfterView();
            }
            elseif(is_a($this->_view, '\\pff\\AView')) {
                $this->_app->getHookManager()->runBeforeView();
                $this->_view->render();
                $this->_app->getHookManager()->runAfterView();
            }
            else {
                throw new \pff\ViewException("The specified View is not valid.");
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

    /**
     * @return string
     */
    public function getControllerName() {
        return $this->_controllerName;
    }

    /**
     * @return string
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * @return \pff\App
     */
    public function getApp() {
        return $this->_app;
    }
}
