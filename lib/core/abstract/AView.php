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
        $this->_publicFolder = $this->_app->getExternalPath().'public'.DS;
        $this->_cssFolder    = $this->_app->getExternalPath().'public'.DS.'css'.DS;
        $this->_imgFolder    = $this->_app->getExternalPath().'public'.DS.'img'.DS;
        $this->_jsFolder     = $this->_app->getExternalPath().'public'.DS.'js'.DS;

        $this->set('pff_path_public',$this->_publicFolder);
        $this->set('pff_path_css',$this->_cssFolder);
        $this->set('pff_path_img',$this->_imgFolder);
        $this->set('pff_path_js',$this->_jsFolder);
        $this->set('pff_root_ext',$this->_app->getExternalPath());
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

    /**
     * @param string $cssFolder
     */
    public function setCssFolder($cssFolder) {
        $this->_cssFolder = $cssFolder;
    }

    /**
     * @return string
     */
    public function getCssFolder() {
        return $this->_cssFolder;
    }

    /**
     * @param string $imgFolder
     */
    public function setImgFolder($imgFolder) {
        $this->_imgFolder = $imgFolder;
    }

    /**
     * @return string
     */
    public function getImgFolder() {
        return $this->_imgFolder;
    }

    /**
     * @param string $jsFolder
     */
    public function setJsFolder($jsFolder) {
        $this->_jsFolder = $jsFolder;
    }

    /**
     * @return string
     */
    public function getJsFolder() {
        return $this->_jsFolder;
    }

    /**
     * @param string $publicFolder
     */
    public function setPublicFolder($publicFolder) {
        $this->_publicFolder = $publicFolder;
    }

    /**
     * @return string
     */
    public function getPublicFolder() {
        return $this->_publicFolder;
    }
}
