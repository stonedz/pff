<?php

namespace pff\modules;

/**
 * File logger exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class LoggerFileException extends \pff\PffException{
    
    public function __construct($message = "", $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
