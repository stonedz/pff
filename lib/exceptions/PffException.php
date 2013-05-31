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

    /**
     * Array of variables passed to a view.
     *
     * Only used with ExceptionHandler module
     *
     * @var array
     */
    private $viewParams;

    public function __construct($message = "", $code = 0, $previous = null, $viewParams = null) {
        parent::__construct($message, $code, $previous);

        if($viewParams !== null) {
            $this->setViewParams($viewParams);
        }
        $this->backtrace = debug_backtrace();
    }

    /**
     * @param array $viewParams
     */
    public function setViewParams($viewParams) {
        $this->viewParams = $viewParams;
    }

    /**
     * @return array
     */
    public function getViewParams() {
        return $this->viewParams;
    }
}
