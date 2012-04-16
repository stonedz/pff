<?php

namespace pff\modules;

/**
 * Generic logger exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class LoggerException extends \pff\PffException {

    /**
     * contains the backtrack of all the callers.
     * 
     * @var array
     */
    public $backtrace;
    
    public function __construct($message = "", $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);
        
        $this->backtrace = debug_backtrace();
    }
    
}

?>
