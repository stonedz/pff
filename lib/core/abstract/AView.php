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

    public function __construct($templateName, \pff\App $app) {
        $this->_app          = $app;
        $this->_templateFile = $templateName;
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
