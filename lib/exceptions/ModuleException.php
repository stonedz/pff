<?php

namespace pff;

/**
 * pff module exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class ModuleException extends \pff\PffException {

    public function __construct($message="", $code=0, $previous=null) {
        parent::__construct($message, $code, $previous);
    }

}
