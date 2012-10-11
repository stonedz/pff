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
     * @var \pff\HookManager
     */
    private $_hookManager;

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

    /**
     * Reference to main app
     *
     * @var \pff\App
     */
    private $_app;

    public function __construct(\pff\Config $cfg) {
        $this->_config      = $cfg;
        $this->_yamlParser  = new \Symfony\Component\Yaml\Parser();
        $this->_hookManager = null;
        //$this->initModules();
    }

    /**
     * Autoload modules specified in config files
     *
     *  @return void
     */
    public function initModules() {
        $moduleList = $this->_config->getConfigData('modules');
        if(count($moduleList) > 0) {
            foreach ($this->_config->getConfigData('modules') as $moduleName) {
                $this->loadModule($moduleName);
            }
        }
    }

    /**
     * Checks for php extensions for pff modules
     *
     * @var $phpExtensions array An array of php extesions names
     * @throws \pff\ModuleException
     */
    private function checkPhpExtensions ($phpExtensions) {
        foreach($phpExtensions as $extension) {
            if(!extension_loaded($extension)){
                throw new \pff\ModuleException("Module loagin failed! A module needs the following php extension in order to load: ".$extension);
            }
        }
    }

    /**
     * Loads a module and its dependencies and then returns the module reference
     *
     * @param string $moduleName
     * @return bool|\pff\AModule
     * @throws \pff\ModuleException
     */
    public function loadModule($moduleName) {
        $moduleFilePathUser = ROOT . DS . 'app' . DS . 'modules' . DS . $moduleName . DS .'module.yaml';
        $moduleFilePathPff = ROOT . DS . 'lib' . DS . 'modules' . DS . $moduleName. DS .'module.yaml';

        if(file_exists($moduleFilePathUser)){
            $moduleFilePath = $moduleFilePathUser;
        }elseif(file_exists($moduleFilePathPff)){
            $moduleFilePath = $moduleFilePathPff;
        }else{
            throw new \pff\ModuleException("Specified module \"".$moduleName."\" does not exist");
        }
        try {
            $moduleConf = $this->_yamlParser->parse(file_get_contents($moduleFilePath));

            if(isset($moduleConf['requires_php_extension']) && is_array($moduleConf['requires_php_extension'])){
                $this->checkPhpExtensions($moduleConf['requires_php_extension']);
            }

            $tmpModule  = new \ReflectionClass('\\pff\\modules\\'.$moduleConf['class']);
            if ($tmpModule->isSubclassOf('\\pff\\AModule')) {
                $moduleName = strtolower($moduleConf['name']);

                if(isset($this->_modules[$moduleName])) { //Module has already been loaded
                    return $this->_modules[$moduleName];
                    //return true;
                }

                $this->_modules[$moduleName] = $tmpModule->newInstance();
                $this->_modules[$moduleName]->setModuleName($moduleConf['name']);
                $this->_modules[$moduleName]->setModuleVersion($moduleConf['version']);
                $this->_modules[$moduleName]->setModuleDescription($moduleConf['desc']);
                $this->_modules[$moduleName]->setConfig($this->_config);
                $this->_modules[$moduleName]->setApp($this->_app);

                if($tmpModule->isSubclassOf('\pff\IHookProvider') && $this->_hookManager !== null){
                    $this->_hookManager->registerHook($this->_modules[$moduleName]);
                }

                if(isset ($moduleConf['requires']) && is_array($moduleConf['requires'])){
                    $this->_modules[$moduleName]->setModuleRequirements($moduleConf['requires']);
                    foreach ($moduleConf['requires'] as $requiredModuleName) {
                        $this->loadModule($requiredModuleName);
                        $this->_modules[$moduleName]->registerRequiredModule($this->_modules[$requiredModuleName]);
                    }
                }
                return $this->_modules[$moduleName];

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

    /**
     * Get the istance of desired module
     *
     * @param string $moduleName
     * @throws ModuleException
     * @return \pff\AModule The requested module
     */
    public function getModule($moduleName) {
        $moduleName = strtolower($moduleName);
        if (isset($this->_modules[$moduleName])) {
            return $this->_modules[$moduleName];
        }
        else {
            try{
               $this->loadModule($moduleName);
            }
            catch(\Exception $e) {
                throw new \pff\ModuleException("Cannot find requested module: $moduleName");
            }
        }
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
     * Sets the Controller for each module
     */
    public function setController(\pff\AController $controller) {
        if(count($this->_modules) > 0) {
            foreach($this->_modules as $module) {
                $module->setController($controller);
            }
        }
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
}
