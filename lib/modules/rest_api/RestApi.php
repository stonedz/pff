<?php

namespace pff\modules;

/**
 * Helper module to build Rest APIs
 *
 * @author paolo.fagni<at>gmail.com
 */
class RestApi extends \pff\AModule implements \pff\IBeforeSystemHook {


    /**
     * Executed before the system startup
     *
     * @return mixed
     */
    public function doBeforeSystem()
    {
         $this->getApp()->addRoute('admin', 'test');
        // TODO: Implement doBeforeSystem() method.
    }
}
