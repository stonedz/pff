<?php

namespace pff;

/**
 * Every view must implement this abstract class
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AView {

    /**
     * @var string The template file
     */
    protected $_templateFile;

    public function __construct($templateName){
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
}
