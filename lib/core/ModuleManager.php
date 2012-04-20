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
     * @var \Symfony\Component\Yaml\Parser
     */
    private $_yamlParser;

    /**
     * Contains loaded modules
     *
     * @var \pff\AModule[]
     */
    private $_modules;

    public function __construct(\pff\Config $cfg) {
        $this->_config = $cfg;
        $this->_yamlParser = new \Symfony\Component\Yaml\Parser();
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
        //$moduleName = strtolower($moduleName);
        $moduleFilePath = ROOT . DS . 'lib' . DS . 'modules' . DS . $moduleName. DS .'module.yaml';
        if (file_exists($moduleFilePath)){
            try {
                $moduleConf = $this->_yamlParser->parse(file_get_contents($moduleFilePath));
                $tmpModule  = new \ReflectionClass('\\pff\\modules\\'.$moduleConf['class']);
                if ($tmpModule->isSubclassOf('\\pff\\AModule')) {
                    $moduleName = strtolower($moduleConf['name']);
                    $this->_modules[$moduleName] = $tmpModule->newInstance();
                    $this->_modules[$moduleName]->setModuleName($moduleConf['name']);
                    $this->_modules[$moduleName]->setModuleVersion($moduleConf['version']);
                    $this->_modules[$moduleName]->setModuleDescription($moduleConf['desc']);
                }
                else {
                    throw new \pff\ModuleException("Invalid module: ".$moduleConf['name']);
                }
            }
            catch( \Symfony\Component\Yaml\Exception\ParseException $e ) {
                throw new \pff\ModuleException("Unable to parse module configuration
                                                    file for $moduleName: ".$e->getMessage());
            }
            catch( \ReflectionException $e) {
                throw new \pff\ModuleException("Unable to create module instance: ". $e->getMessage());
            }
        }
        else {
            throw new \pff\ModuleException("Specified module \"".$moduleName."\" does not exist");
        }
    }

    /**
     * Get the istance of desired module
     *
     * @param string $moduleName
     */
    public function getModule($moduleName) {
        $moduleName = strtolower($moduleName);
        if (isset($this->_modules[$moduleName])) {
            return $this->_modules[$moduleName];
        }
        else {
            throw new \pff\ModuleException("Cannot find requested module: $moduleName");
        }
    }
}
