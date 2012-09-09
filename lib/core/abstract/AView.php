<?php

namespace pff;

/**
 * Every view must implement this abstract class
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AView {

    /**
     * @var \pff\App
     */
    private $_app;

    /**
     * @var string The template file
     */
    protected $_templateFile;

    /**
     * @var string Path to the public folder
     */
    protected $_publicFolder;

    /**
     * @var string Path to public css path
     */
    protected $_cssFolder;

    /**
     * @var string Path to public img path
     */
    protected $_imgFolder;

    /**
     * @var string Path to the javascript folder
     */
    protected $_jsFolder;

    public function __construct($templateName, \pff\App $app) {
        $this->_app          = $app;
        $this->_templateFile = $templateName;
        $this->_publicFolder = ROOT.DS.'public'.DS;
        $this->_cssFolder    = ROOT.DS.'public'.DS.'css'.DS;
        $this->_imgFolder    = ROOT.DS.'public'.DS.'img'.DS;
        $this->_jsFolder     = ROOT.DS.'public'.DS.'js'.DS;
    }

    abstract public function set($name, $value);

    abstract public function render();

    /**
     * @return string
     */
    public function getTemplateFile() {
        return $this->_templateFile;
    }

    /**
     * @return \pff\App
     */
    public function getApp() {
        return $this->_app;
    }
}
