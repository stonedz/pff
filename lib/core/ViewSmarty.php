<?php

namespace pff;

/**
 * Smarty view adapter
 *
 * @author paolo.fagni<at>gmail.com
 */
class ViewSmarty extends \pff\AView
{

    /**
     * @var \Smarty
     */
    protected $_smarty;

    public function __construct($templateName, \pff\App $app)
    {
        $this->_smarty = new \Smarty(); // The smarty instance should be accessible before
        parent::__construct($templateName, $app);
        $this->_smarty->template_dir = ROOT . DS . 'app' . DS . 'views' . DS . 'smarty' . DS . 'templates' . DS;
        $this->_smarty->compile_dir = ROOT . DS . 'app' . DS . 'views' . DS . 'smarty' . DS . 'compiled_templates' . DS;
        $this->_smarty->config_dir = ROOT . DS . 'app' . DS . 'views' . DS . 'smarty' . DS . 'configs' . DS;
        $this->_smarty->cache_dir = ROOT . DS . 'app' . DS . 'views' . DS . 'smarty' . DS . 'cache' . DS;
        $this->_smarty->registerPlugin('function', 'renderAction', array($this, 'smarty_plugin_renderAction'));
    }

    public function smarty_plugin_renderAction($params, $smarty)
    {
        if (!isset($params['params'])) {
            $params['params'] = array();
        }

        if (!isset($params['action'])) {
            $params['action'] = 'index';
        }
        $this->renderAction($params['controller'], ($params['action']), $params['params']);
    }

    public function set($name, $value)
    {
        $this->_smarty->assign($name, $value);
    }

    public function render()
    {
        $this->_smarty->display($this->_templateFile);
    }
}
