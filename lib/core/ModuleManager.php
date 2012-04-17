<?php

namespace pff;

/**
 * Manages pff modules
 *
 * @author paolo.fagni<at>gmail.com
 */
class ModuleManager {

    /**
     * @var \pff\Config
     */
    private $_config;

    /**
     * Contains loaded modules
     *
     * @var \pff\AModule[]
     */
    private $_modules;

    public function __construct(\pff\Config $cfg) {
        $this->_config = $cfg;
        $this->initModules();
    }

    /**
     * Autoload modules specified in config files
     *
     *  @return void
     */
    public function initModules() {
        foreach ($this->_config->getConfig('modules') as $moduleName) {
            $this->loadModule($moduleName);
        }
    }

    /**
     * Loads a module
     *
     * @param string $moduleName
     * @throws \pff\ModuleException
     */
    public function loadModule($moduleName) {
        $yamlParser     = new \Symfony\Component\Yaml\Parser();
        $moduleFilePath = ROOT . DS . 'lib' . DS . 'modules' . DS . $moduleName. DS .'module.yaml';
        if (file_exists($moduleFilePath)){
            try {
                $moduleConf = $yamlParser->parse(file_get_contents($moduleFilePath));
                $tmpModule  = new \ReflectionClass('\\pff\\modules\\'.$moduleConf['class']);
                if ($tmpModule->isSubclassOf('\\pff\\AModule')) {
                    $this->_modules[$moduleConf['name']] = $tmpModule->newInstance();
                    $this->_modules[$moduleConf['name']]->setModuleName($moduleConf['name']);
                    $this->_modules[$moduleConf['name']]->setModuleVersion($moduleConf['version']);
                    $this->_modules[$moduleConf['name']]->setModuleDescription($moduleConf['desc']);
                }
                else {
                    throw new \pff\ModuleException("Invalid module: ".$moduleConf['name']);
                }
            }
            catch( \Symfony\Component\Yaml\Exception\ParseException $e ) {
                throw new \pff\ModuleException("Unable to parse module configuration
                                                    file for $moduleName: ".$e->getMessage());
            }
        }
    }

    /**
     * Get the istance of desired module
     *
     * @param string $moduleName
     */
    public function getModule($moduleName) {
        if (isset($this->_modules[$moduleName])) {
            return $this->_modules[$moduleName];
        }
        else {
            throw new \pff\ModuleException("Cannot find requested module: $moduleName");
        }
    }
}
