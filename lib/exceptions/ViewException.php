<?php

namespace pff;

/**
 * View exception
 *
 * @author paolo.fagni<at>gmail.com
 */
class ViewException extends \pff\PffException {

    public function __construct($message="", $code=0, $previous=NULL) {
        parent::__construct($message, $code, $previous);
    }

}
