<?php

namespace pff\modules;

/**
 * This pff module automatically loads an header or a footer
 *
 * @author paolo.fagni<at>gmail.com
 */
class AutomaticHeaderFooter
    extends \pff\AModule
    implements \pff\IBeforeViewHook, \pff\IAfterHook, \pff\IConfigurableModule {

    /**
     * @var bool
     */
    private $_footerController;

    /**
     * @var bool
     */
    private $_headerController;

    /**
     * @var bool
     */
    private $_footerGlobal;

    /**
     * @var bool
     */
    private $_headerGlobal;


    public function __construct($confFile='automatic_header_footer/module.conf.yaml') {
        $moduleconfig = $this->readConfig($confFile);
        $this->loadConfig($moduleconfig);
    }

    /**
     * Initializes the module with defined configuration
     *
     * @param array $parsedConfig A parsed config in the form of an array
     */
    public function loadConfig($parsedConfig) {
        $this->_footerController = $parsedConfig['moduleConf']['automatic_controller_footer'];
        $this->_footerGlobal     = $parsedConfig['moduleConf']['automatic_global_footer'];
        $this->_headerController = $parsedConfig['moduleConf']['automatic_controller_header'];
        $this->_headerGlobal     = $parsedConfig['moduleConf']['automatic_global_header'];
    }

    /**
     * Adds the header as the first view to be rendered. The controller based-header has
     * always the precedence on the global header
     *
     * @return mixed
     */
    public function doBeforeView() {
        if($this->_headerController) {
            $viewPath = ROOT . DS . 'app'.DS. 'views'. DS.
                strtolower($this->_controller->getControllerName()) .DS.
                strtolower($this->_controller->getAction()).DS . 'header.php';
            if(file_exists($viewPath)){
                $this->_controller->addViewPre(\pff\FView::create(strtolower($this->_controller->getControllerName()) .DS.
                strtolower($this->_controller->getAction()).DS . 'header.php',$this->getController()->getApp()));
            }
            elseif($this->_headerGlobal) {
                $viewPath = ROOT . DS . 'app'.DS. 'views'. DS.'header.php';
                if(file_exists($viewPath)){
                    $this->_controller->addViewPre(\pff\FView::create('header.php', $this->getController()->getApp()));
                }
            }
        }
    }

    /**
     * Executes actions after the views are rendered
     *
     * @return mixed
     */
    public function doAfter() {
        if($this->_footerController) {
            $viewPath = ROOT . DS . 'app'.DS. 'views'. DS.
                strtolower($this->_controller->getControllerName()) .DS.
                strtolower($this->_controller->getAction()).DS . 'footer.php';
            if(file_exists($viewPath)){
                $this->_controller->addView(\pff\FView::create(strtolower($this->_controller->getControllerName()) .DS.
                    strtolower($this->_controller->getAction()).DS . 'footer.php', $this->getController()->getApp()));
            }
            elseif($this->_footerGlobal) {
                $viewPath = ROOT . DS . 'app'.DS. 'views'. DS.'footer.php';
                if(file_exists($viewPath)){
                    $this->_controller->addView(\pff\FView::create('footer.php', $this->getController()->getApp()));
                }
            }
        }
    }

}
