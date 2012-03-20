<?php

namespace pff;

/**
 * Every controller must implement this abstract class
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class AController {

    /**
     * @var string
     */
    private $_controllerName;

    /**
     * @var string
     */
    private $_action;

    /**
     * @var
     * \pff\AView
     */
    private $_view;

    /**
     * Creates a controller
     *
     * @param string $controllerName The controller's name (used to load correct model)
     * @param string $action Action to perform
     */
    public function __construct($controllerName, $action = 'index') {

    }

    /**
     * Method executed before the action
     */
    public function beforeAction() {
    }

    /**
     * Method executed after the action
     */
    public function afterAction() {
    }

    /**
     * All controllers should at leas implement an index
     *
     * @abstract
     * @return mixed
     */
    abstract public function index();
}
