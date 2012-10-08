<?php

namespace pff\modules;

/**
 * Manages uncaught exceptions
 *
 * @author paolo.fagni<at>gmail.com
 */
class ExceptionHandler extends \pff\AModule implements \pff\IBeforeSystemHook
{

    /**
     * Executed before the system startup
     *
     * @return mixed
     */
    public function doBeforeSystem()
    {
        set_exception_handler(array($this, 'manageExceptions'));
    }

    public function manageExceptions(\Exception $exception)
    {
        $code = $exception->getCode();
        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $code . '_View.php')) {
            $viewPath = $code . '_View.php';
        } elseif (file_exists(ROOT . DS . 'lib' . DS . 'modules' . DS . 'exception_handler' . DS . 'views' . DS . 'default' . $code . '_View.php')) {
            $viewPath = '..' . DS . '..' . DS . 'lib' . DS . 'modules' . DS . 'exception_handler' . DS . 'views' . DS . 'default' . $code . '_View.php';
        }
        else {
            $viewPath = '..' . DS . '..' . DS . 'lib' . DS . 'modules' . DS . 'exception_handler' . DS . 'views' . DS . 'defaultError_View.php';
        }
        //die($viewPath);

        $view = \pff\FView::create($viewPath, $this->getApp());
        $view->set('message', $exception->getMessage());
        $view->set('trace', $exception->getTrace());

        $view->render();
    }
}
