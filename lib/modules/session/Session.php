<?php

namespace pff\modules;

/**
 * Module to manage sessions
 *
 * @author paolo.fagni<at>gmail.com
 */
class Session extends \pff\AModule implements \pff\IBeforeHook {


    public function doBefore() {
        session_start();
    }
}
