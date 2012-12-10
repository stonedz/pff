<?php

namespace pff;

/**
 * Generic pff exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class PffException extends \Exception {

    /**
     * Contains the backtrace for the caller
     *
     * @var array
     */
    public $backtrace;

    public function __construct($message = "", $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->backtrace = debug_backtrace();
    }
}
