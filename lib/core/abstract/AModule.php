<?php

namespace pff;

/**
 * Abstract class for pff modules
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AModule {

    /**
     * The module name
     *
     * @var string
     */
    private $_moduleName;

    /**
     * The module version
     *
     * @var string
     */
    private $_moduleVersion;

    /**
     * Module description
     *
     * @var string
     */
    private $_moduleDescription;

    /**
     * Array of modules names required by this module
     *
     * @var array
     */
    private $_moduleRequirements;

    /**
     * Contains modules required by this module
     *
     * @var \pff\AModule[]
     */
    private $_requiredModules;

    /**
     * @var \pff\Config
     */
    private $_config;

    /**
     * @var \pff\AController
     */
    protected $_controller;

    /**
     * Reference to main app
     *
     * @var \pff\App
     */
    protected $_app;

    /**
     * @param string $moduleName
     */
    public function setModuleName($moduleName) {
        $this->_moduleName = $moduleName;
    }

    /**
     * @return string
     */
    public function getModuleName() {
        return $this->_moduleName;
    }

    /**
     * @param string $moduleVersion
     */
    public function setModuleVersion($moduleVersion) {
        $this->_moduleVersion = $moduleVersion;
    }

    /**
     * @return string
     */
    public function getModuleVersion() {
        return $this->_moduleVersion;
    }

    /**
     * @return string
     */
    public function getModuleDescription() {
        return $this->_moduleDescription;
    }

    /**
     * @param string $moduleDescription
     */
    public function setModuleDescription($moduleDescription) {
        $this->_moduleDescription = $moduleDescription;
    }

    /**
     * Injects a required module reference to the module
     *
     * @param \pff\AModule $module
     */
    public function registerRequiredModule(\pff\AModule $module) {
        $this->_requiredModules[strtolower($module->getModuleName())] = $module;
    }

    /**
     * Gets a module
     *
     * @param string $moduleName
     * @return \pff\AModule|null
     */
    public function getRequiredModules($moduleName) {
        $moduleName = strtolower($moduleName);
        if (isset($this->_requiredModules[$moduleName])) {
            return $this->_requiredModules[$moduleName];
        }
        else {
            return null;
        }
    }

    /**
     * @param array $moduleRequirements
     */
    public function setModuleRequirements($moduleRequirements) {
        $this->_moduleRequirements = $moduleRequirements;
    }

    /**
     * @return array
     */
    public function getModuleRequirements() {
        return $this->_moduleRequirements;
    }

    /**
     * @param \pff\Config $config
     */
    public function setConfig($config) {
        $this->_config = $config;
    }

    /**
     * @return \pff\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * @param \pff\AController $controller
     */
    public function setController($controller) {
        $this->_controller = $controller;
    }

    /**
     * @return \pff\AController
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * @param \pff\App $app
     */
    public function setApp($app) {
        $this->_app = $app;
    }

    /**
     * @return \pff\App
     */
    public function getApp() {
        return $this->_app;
    }

    /**
     * Reads the configuration file ad returns a configuration array
     *
     * @param string $configFile The module filename
     * @throws \pff\ModuleException
     * @throws \pff\ModuleException
     * @return array
     */
    public function readConfig($configFile) {
        $yamlParser   = new \Symfony\Component\Yaml\Parser();
        $userConfPath = ROOT . DS . 'app' . DS . 'config' . DS . 'modules' . DS . $configFile;
        $libConfPath  = ROOT . DS . 'lib' . DS . 'modules' . DS . $configFile;
        if (file_exists($userConfPath)) {
            $confPath = $userConfPath;
        } elseif (file_exists($libConfPath)) {
            $confPath = $libConfPath;
        } else {
            throw new \pff\ModuleException ("Module configuration file not found!");
        }

        try {
            $conf = $yamlParser->parse(file_get_contents($confPath));
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
            throw new \pff\ModuleException("Unable to parse module configuration
                                            file for AutomaticHeaderFooter module: " . $e->getMessage());
        }
        return $conf;
    }
}
