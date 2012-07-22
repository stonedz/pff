<?php

namespace pff;

/**
 * Smarty view adapter
 *
 * @author paolo.fagni<at>gmail.com
 */
class ViewSmarty extends \pff\AView {

    /**
     * @var \Smarty
     */
    private $_smarty;

    public function __construct($templateName, \pff\App $app) {
        parent::__construct($templateName, $app);
        $this->_smarty               = new \Smarty();
        $this->_smarty->template_dir = ROOT.DS.'app'.DS.'views'.DS.'smarty'.DS.'templates'.DS ;
        $this->_smarty->compile_dir  = ROOT.DS.'app'.DS.'views'.DS.'smarty'.DS.'compiled_templates'.DS ;
        $this->_smarty->config_dir   = ROOT.DS.'app'.DS.'views'.DS.'smarty'.DS.'configs'.DS ;
        $this->_smarty->cache_dir    = ROOT.DS.'app'.DS.'views'.DS.'smarty'.DS.'cache'.DS ;
    }

    public function set($name, $value) {
        $this->_smarty->assign($name,$value);
    }

    public function render() {
        $this->_smarty->display($this->_templateFile);
    }
}
