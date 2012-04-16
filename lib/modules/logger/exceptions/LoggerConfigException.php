<?php

namespace pff\modules;

/**
 * Logger config related exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class LoggerConfigException extends \pff\PffException{
    
    public function __construct($message = "", $code=0, $previous=null) {
        parent::__construct($message, $code, $previous);
    }
}
