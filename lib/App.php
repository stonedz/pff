<?php

namespace pff;

/**
 * Main app
 *
 * @author paolo.fagni<at>gmail.com
 */
class App {

    /**
     * @var string
     */
    private $_url;

    /**
     * Contains user defined routes for page controllers
     *
     * @var array
     */
    private $_staticRoutes;

    /**
     * Contains user defined routes
     *
     * @var array
     */
    private $_routes;

    /**
     * @var \pff\Config
     */
    private $_config;

    /**
     * @var \pff\ModuleManager
     */
    private $_moduleManager;

    /**
     * @var \pff\HookManager
     */
    private $_hookManager;

    /**
     * @var \pff\HelperManager
     */
    private $_helperManager;

    /**
     * @param string $url The request URL
     * @param Config $config
     * @param ModuleManager $moduleManager
     * @param HookManager $hookManager
     */
    public function __construct($url,
                                Config $config,
                                ModuleManager $moduleManager,
                                HookManager $hookManager) {
        $this->setUrl($url);

        $this->_config        = $config;
        $this->_hookManager   = $hookManager;
        $this->_moduleManager = $moduleManager;
        $this->_moduleManager->setApp($this);

        /*
         * ModuleManager needs a HooklManager instance to initialize modules
         * which provide hooks
         */
        $this->_moduleManager->setHookManager($this->_hookManager);
        $this->_moduleManager->initModules(); //Loads modules specified in the configuration

    }

    /**
     * Sets error reporting
     */
    public function setErrorReporting() {
        if ($this->_config->getConfigData('development_environment') == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }
    }

    /**
     * Check for Magic Quotes and remove them
     *
     * @param $value array|string
     * @return array|string
     * @codeCoverageIgnore
     */
    private function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    /**
     * Removes magic quotes from requests
     * @codeCoverageIgnore
     */
    public function removeMagicQuotes() {
        if (get_magic_quotes_gpc()) {
            $_GET    = $this->stripSlashesDeep($_GET);
            $_POST   = $this->stripSlashesDeep($_POST);
            $_COOKIE = $this->stripSlashesDeep($_COOKIE);
        }
    }

    /**
     * Check register globals and remove them
     *
     * @codeCoverageIgnore
     */
    public function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * Adds a static route to a page (the result is something similar to page controller pattern).
     *
     * @param string $request
     * @param string $destinationPage
     * @throws \pff\RoutingException
     */
    public function addStaticRoute($request, $destinationPage) {
        if (file_exists(ROOT . DS . 'app' . DS . 'pages' . DS . $destinationPage)) {
            $this->_staticRoutes[$request] = $destinationPage;
        } else {
            throw new RoutingException('Non existant static route specified: ' . $destinationPage);
        }
    }

    /**
     * Adds a non-standard MVC route, for example request xxx to yyy_Controller.
     *
     * @param string $request
     * @param string $destinationController
     * @throws \pff\RoutingException
     */
    public function addRoute($request, $destinationController) {
        $explodedDestination = explode('/', $destinationController);
        if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . ucfirst($explodedDestination[0]) . '_Controller.php')) {
            $this->_routes[$request] = $destinationController;
        } else {
            throw new RoutingException('Non existant MVC route specified: ' . $destinationController);
        }

    }

    /**
     * Apply static routes.
     *
     * @param string $request
     * @return bool True if a match is found
     */
    public function applyStaticRouting(&$request) {
        if (isset($this->_staticRoutes[$request])) {
            $request = $this->_staticRoutes[$request];
            $request = 'app' . DS . 'pages' . DS . $request;
            return true;
        }
        return false;
    }

    /**
     * Apply user-defined MVC routes.
     *
     * @param string $request
     * @param null|string $action If the route has an action specified (ex. admin/show will be filled wiith "show")
     * @return bool True if a match is found
     */
    public function applyRouting(&$request, &$action = null) {
        if (isset($this->_routes[strtolower($request)])) {
            $explodedTarget = explode('/', $this->_routes[strtolower($request)]);
            if (isset($explodedTarget[1])) { // we have an action for this route!
                $action = $explodedTarget[1];
            }
            $request = $explodedTarget[0];
            $request = ucfirst($request) . '_Controller';
            return true;
        }
        return false;
    }

    /**
     * Runs the application
     */
    public function run() {
        $this->_hookManager->runBeforeSystem();

        $urlArray = explode('/', $this->_url);
        //Deletes last element if empty
        $lastElement = end($urlArray);
        if ($lastElement == '') {
            array_pop($urlArray);
        }
        //If not empty let's see if it's a list of GET parameters
        //elseif('?' == substr($lastElement,0,1)){
        //   echo substr($lastElement,1);
        //}
        reset($urlArray);


        // If present take the first element as the controller
        $tmpController = isset($urlArray[0]) ? array_shift($urlArray) : 'index';
        // If present take the second element as the action
        //$action = isset($urlArray[0]) ? array_shift($urlArray) : 'index';
        $action = null;

        if ($this->applyStaticRouting($tmpController)) {
            $this->_hookManager->runBefore(); // Runs before controller hooks
            include(ROOT . DS . $tmpController);
            $this->_hookManager->runAfter(); // Runs after controller hooks
        } elseif ($this->applyRouting($tmpController, $action)) {
            ($action === null) ? $action = 'index' : $action;
            include(ROOT . DS . 'app' . DS . 'controllers' . DS . $tmpController . '.php');
            $controller = new $tmpController($tmpController, $this, $action, $urlArray);
        } elseif (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . ucfirst($tmpController) . '_Controller.php')) {
            $action = isset($urlArray[0]) ? array_shift($urlArray) : 'index';
            include (ROOT . DS . 'app' . DS . 'controllers' . DS . ucfirst($tmpController) . '_Controller.php');
            $controllerClassName = ucfirst($tmpController) . '_Controller';
            $controller          = new $controllerClassName($tmpController, $this, $action, $urlArray);
        } else {
            throw new RoutingException('Cannot find a valid controller.', 404);
        }

        if (isset($controller)) {
            $this->_moduleManager->setController($controller); // We have a controller, let the modules know about it
            $this->_hookManager->runBefore(); // Runs before controller hooks
            if ((int)method_exists($controller, $action)) {
                call_user_func_array(array($controller, "beforeAction"), $urlArray);
                call_user_func_array(array($controller, $action), $urlArray);
                call_user_func_array(array($controller, "afterAction"), $urlArray);
                $this->_hookManager->runAfter(); // Runs after controller hooks
            } else {
                throw new RoutingException('Not a valid action: ' . $action, 400);
            }
        }

    }

    /**
     * Returns the external path of the application. For example http://www.xxx.com/base_path
     *
     * @return string
     */
    public function getExternalPath() {
        if ($this->_config->getConfigData('development_environment') == true) {
            $extPath = EXT_ROOT . $this->_config->getConfigData('base_path_dev');
        } else {
            $extPath = EXT_ROOT . $this->_config->getConfigData('base_path');
        }
        return $extPath;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * @return array
     */
    public function getRoutes() {
        return $this->_routes;
    }

    /**
     * @return array
     */
    public function getStaticRoutes() {
        return $this->_staticRoutes;
    }

    /**
     * @return \pff\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * @param \pff\HookManager $hookManager
     */
    public function setHookManager($hookManager) {
        $this->_hookManager = $hookManager;
    }

    /**
     * @return \pff\HookManager
     */
    public function getHookManager() {
        return $this->_hookManager;
    }

    /**
     * @param \pff\ModuleManager $moduleManager
     */
    public function setModuleManager($moduleManager) {
        $this->_moduleManager = $moduleManager;
    }

    /**
     * @return \pff\ModuleManager
     */
    public function getModuleManager() {
        return $this->_moduleManager;
    }

    /**
     * @param \pff\HelperManager $helperManager
     */
    public function setHelperManager($helperManager) {
        $this->_helperManager = $helperManager;
    }

    /**
     * @return \pff\HelperManager
     */
    public function getHelperManager() {
        return $this->_helperManager;
    }
}
