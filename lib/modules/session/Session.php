<?php

namespace pff\modules;

/**
 * Module to manage sessions
 *
 * @author paolo.fagni<at>gmail.com
 */
class Session extends \pff\AModule implements \pff\IBeforeSystemHook {


    /**
     * Executed before the system startup
     *
     * @return mixed
     */
    public function doBeforeSystem()
    {
        session_start();
        // TODO: Implement doBeforeSystem() method.
    }
}
