<?php

namespace pff\modules;

use pff\AModule;
use pff\IBeforeHook;
use pff\IConfigurableModule;

class MobileViews extends AModule implements IConfigurableModule, IBeforeHook {

    /**
     * @var string
     */
    private $_suffix;

    /**
     * Session var name.
     *
     * If $_SESSION[$_sessionName] is set to true it means the user is currently using a mobile device
     *
     * @var string
     */
    private $_sessionName;

    /**
     * Session var name for auto-mode
     *
     * If $_SESSION[$_sessionAutoName] is set to _false_ it means the default behaviour is to ignore mobile device specific views
     *
     * @var string
     */
    private $_sessionAutoName;

    /**
     * @var bool
     */
    private $_defaultBehaviour;

    /**
     * @var \Mobile_Detect
     */
    private $_md;

    /**
     * @var bool
     */
    private $_isMobile = false;

    /**
     * @param string $confFile Path to configuration file
     */
    public function __construct($confFile = 'mobile_views/module.conf.yaml') {
        $this->loadConfig($this->readConfig($confFile));
    }

    /**
     * @param array $parsedConfig
     * @return mixed
     */
    public function loadConfig($parsedConfig) {
        $this->_suffix           = $parsedConfig['moduleConf']['filenameSuffix'];
        $this->_sessionName      = $parsedConfig['moduleConf']['sessionVarName'];
        $this->_sessionAutoName  = $parsedConfig['moduleConf']['sessionVarAutoName'];
        $this->_defaultBehaviour = $parsedConfig['moduleConf']['showMobileVersion'];

        $this->_md = new \Mobile_Detect();
    }

    /**
     * Executes actions before the Controller
     *
     * @return mixed
     */
    public function doBefore() {
        $this->_isMobile = $this->_md->isMobile();

        $_SESSION[$this->_sessionAutoName] = $this->_defaultBehaviour;
        $_SESSION[$this->_sessionName]     = $this->_isMobile;
    }

    public function shouldLoadMobileViews() {
        if($_SESSION[$this->_sessionAutoName] && $this->_isMobile) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isMobile() {
        return !$this->_isMobile;
    }

    /**
     * Sets the auto mode on or off,
     *
     * true = ON and false = OFF
     *
     * @param bool $val
     */
    private function setAutoMode($val) {
        $this->_defaultBehaviour           = $val;
        $_SESSION[$this->_sessionAutoName] = $this->_defaultBehaviour;
    }

    public function autoModeOn() {
        $this->setAutoMode(true);
    }

    public function autoModeOff() {
        $this->setAutoMode(false);
    }

    public function getAutoMode() {
        return $_SESSION[$this->_sessionAutoName];
    }

    // GETTERS & SETTERS

    /**
     * @param boolean $defaultBehaviour
     */
    public function setDefaultBehaviour($defaultBehaviour) {
        $this->_defaultBehaviour = $defaultBehaviour;
    }

    /**
     * @return boolean
     */
    public function getDefaultBehaviour() {
        return $this->_defaultBehaviour;
    }

    /**
     * @param string $sessionName
     */
    public function setSessionName($sessionName) {
        $this->_sessionName = $sessionName;
    }

    /**
     * @return string
     */
    public function getSessionName() {
        return $this->_sessionName;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix($suffix) {
        $this->_suffix = $suffix;
    }

    /**
     * @return string
     */
    public function getSuffix() {
        return $this->_suffix;
    }


}