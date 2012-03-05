<?php
/**
 * Main app
 *
 * Date: 3/2/12
 *
 * @author paolo.fagni<at>gmail.com
 * @category lib
 * @version 0.1
 */

class App{

    /**
     * @var string
     */
    private $_url;

    /**
     * @var array Contains a map of routes
     */
    private $_routes;

    /**
     * @var array Contains a map of _static_ routes. (pages)
     */
    private $_staticRoutes;

    /**
     * @param $url string The request URL
     */
    public function __construct($url){
        $this->setUrl($url);
    }

    /**
     * Sets error reporting
     */
    public function setErrorReporting() {
        if (DEVELOPMENT_ENVIRONMENT == true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
        }
    }

    /**
     * Check for Magic Quotes and remove them
     *
     * @param $value array|string
     * @return array|string
     */
    private function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    /**
     * Removes magic quotes from requests
     */
    public function removeMagicQuotes() {
        if ( get_magic_quotes_gpc() ) {
            $_GET    = $this->stripSlashesDeep($_GET   );
            $_POST   = $this->stripSlashesDeep($_POST  );
            $_COOKIE = $this->stripSlashesDeep($_COOKIE);
        }
    }

    /**
     * Check register globals and remove them
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
     * Add a static route to the application
     *
     * For example $app->addRoute('admin','adminController');
     *
     * @param $url string Desired request
     * @param $destController string Controller to manage request
     */
    public function addRoute($url, $destController){
        $this->_routes[$url] = $destController;
    }

    /**
     * Add a static route (NO MVC!), the destPage
     *
     * @param $url string Desired request
     * @param $destPage
     */
    public function addStaticRoute($url, $destPage){
        $this->_staticRoutes[$url] = $destPage;
    }

    /**
     * Apply the routes specified by the user to the request
     *
     * @return array The new urlArray;
     */
    private function applyRouting(){

    }

    /**
     * Runs the application
     */
    public function run(){
        $urlArray = explode('/', $this->_url);


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
}





