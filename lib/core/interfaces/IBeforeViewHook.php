<?php

namespace pff;

/**
 * Implements a hook before the registered views
 *
 * @author paolo.fagni<at>gmail.com
 */
interface IBeforeViewHook extends \pff\IHookProvider {

    /**
     * Executes actions before the Views are rendered
     *
     * @abstract
     * @return mixed
     */
    public function doBeforeView();
}
