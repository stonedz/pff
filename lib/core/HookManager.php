<?php

namespace pff;

/**
 * Hook mediator
 *
 * @author paolo.fagni<at>gmail.com
 */
class HookManager {

    /**
     * Array of hooks to be executed before system startup
     *
     * @var \pff\IBeforeSystemHook[]
     */
    private $_beforeSystem;

    /**
     * Array of hooks to be executed before the controller
     *
     * @var \pff\IBeforeHook[]
     */
    private $_beforeController;

    /**
     * Array of hooks to be executed after the controller
     *
     * @var \pff\IAfterHook[]
     */
    private $_afterController;

    /**
     * Array of hooks to be executed before the Views are rendered
     *
     * @var \pff\IBeforeViewHook[]
     */
    private $_beforeView;


    /**
     * Array of hooks to be executed after the Views are rendered
     *
     * @var \pff\IAfterViewHook[]
     */
    private $_afterView;

    /**
     * @var \pff\Config
     */
    private $_config;

    public function __construct(\pff\Config $cfg) {
        $this->_config = $cfg;
    }

    /**
     * Registers a hook provider
     *
     * @param \pff\IHookProvider $prov
     * @throws \pff\HookException
     */
    public function registerHook(\pff\IHookProvider $prov) {
        $found = false;

        if(is_a($prov, '\\pff\\IBeforeHook')) {
            $this->_beforeController[] = $prov;
            $found                     = true;
        }

        if(is_a($prov, '\\pff\\IAfterHook')) {
            $this->_afterController[] = $prov;
            $found                    = true;
        }

        if(is_a($prov, '\\pff\\IBeforeSystemHook')) {
            $this->_beforeSystem[] = $prov;
            $found                 = true;
        }

        if(is_a($prov, '\\pff\\IBeforeViewHook')) {
            $this->_beforeView[] = $prov;
            $found               = true;
        }

        if(is_a($prov, '\\pff\\IAfterViewHook')) {
            $this->_afterView[] = $prov;
            $found              = true;

        }
        if(!$found) {
            throw new \pff\HookException("Cannot add given class as a hook provider: ". get_class($prov));
        }
    }

    /**
     * Executes the registered methods (before the system)
     *
     * @return void
     */
    public function runBeforeSystem() {
        if($this->_beforeSystem !== null) {
            foreach($this->_beforeSystem as $hookProvider) {
                $hookProvider->doBeforeSystem();
            }
        }
    }

    /**
     * Executes the registered methods (before the controller)
     *
     * @return void
     */
    public function runBefore() {
        if($this->_beforeController !== null) {
            foreach($this->_beforeController as $hookProvider) {
                $hookProvider->doBefore();
            }
        }
    }

    /**
     * Executes the registered methods (after the controller)
     *
     * @return void
     */
    public function runAfter() {
        if($this->_afterController !== null) {
            foreach($this->_afterController as $hookProvider) {
                $hookProvider->doAfter();
            }
        }
    }

    /**
     * Executes the registered methods (before the View)
     *
     * @return void
     */
    public function runBeforeView() {
        if($this->_beforeView !== null) {
            foreach($this->_beforeView as $hookProvider) {
                $hookProvider->doBeforeView();
            }
        }
    }

    /**
     * Executes the registered methods (after the View)
     *
     * @return void
     */
    public function runAfterView() {
        if($this->_afterView !== null) {
            foreach($this->_afterView as $hookProvider) {
                $hookProvider->doAfterView();
            }
        }
    }

    /**
     * @return \pff\IAfterHook[]
     */
    public function getAfterController() {
        return $this->_afterController;
    }

    /**
     * @return \pff\IBeforeHook[]
     */
    public function getBeforeController() {
        return $this->_beforeController;
    }

    /**
     * @return \pff\IBeforeSystemHook[]
     */
    public function getBeforeSystem() {
        return $this->_beforeSystem;
    }

    /**
     * @return IAfterViewHook[]
     */
    public function getAfterView() {
        return $this->_afterView;
    }

    /**
     * @return IBeforeViewHook[]
     */
    public function getBeforeView() {
        return $this->_beforeView;
    }
}
