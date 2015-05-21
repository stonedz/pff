<?php

namespace pff\modules;

/**
 * This module loads a specific controller if the user requested controller is not valid
 *
 * @author paolo.fagni<at>gmail.com
 */
class DefaultController extends \pff\AModule implements \pff\IConfigurableModule, \pff\IBeforeSystemHook{

    /**
     * @var string
     */
    private $_defaultController;

    public function __construct($confFile = 'default_controller/module.conf.yaml') {
        $this->loadConfig($this->readConfig($confFile));
    }

    /**
     * Parse the configuration file
     *
     * @param array $parsedConfig
     * @return mixed|void
     */
    public function loadConfig($parsedConfig) {
        $this->_defaultController = $parsedConfig['moduleConf']['defaultController'];
    }

    /**
     * Executed before the system startup
     *
     * @return mixed
     */
    public function doBeforeSystem() {
        $tmpUrl = $this->_app->getUrl();
        $tmpUrl = explode('/', $tmpUrl);
        if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . ucfirst($tmpUrl[0]) . '_Controller.php')) {
          return;
        }
        elseif (file_exists(ROOT.DS.'app'.DS.'pages'.DS.$tmpUrl[0]) && $tmpUrl[0] != '') {
          return;
        }
        $this->_app->setUrl($this->_defaultController.'/'.implode('/',$tmpUrl));
    }
}
