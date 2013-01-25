<?php

namespace pff;

/**
 * Implements a hook after the registered views
 *
 * @author paolo.fagni<at>gmail.com
 */
interface IAfterViewHook extends \pff\IHookProvider {

    /**
     * Executes actions after the views are rendered
     *
     * @abstract
     * @return mixed
     */
    public function doAfterView();
}
