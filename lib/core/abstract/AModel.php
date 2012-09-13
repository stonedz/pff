<?php

namespace pff;

/**
 * Every model must implement this abstract class
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AModel {

    /**
     * @var \pff\App
     */
    protected $_app;

    public function setApp(\pff\App $app) {
        $this->_app = $app;
    }

}
