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
}
