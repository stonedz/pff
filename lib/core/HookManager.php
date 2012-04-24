<?php

namespace pff;

/**
 * Hook mediator
 *
 * @author paolo.fagni<at>gmail.com
 */
class HookManager {

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

        if(is_a($prov, '\\pff\IAfterHook')) {
            $this->_afterController[] = $prov;
            $found                    = true;
        }

        if(!$found) {
            throw new \pff\HookException("Cannot add given class as a hook provider: ". get_class($prov));
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
}
