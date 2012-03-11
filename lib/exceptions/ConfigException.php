<?php

namespace pff;

/**
 * Configuration or bootstrap exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class ConfigException extends \pff\PffException {

    public function __construct($message="", $code=0, $previous=NULL) {
        parent::__construct($message, $code, $previous);
    }

}
