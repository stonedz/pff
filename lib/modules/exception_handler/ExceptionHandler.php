<?php

namespace pff\modules;

/**
 * Manages uncaught exceptions
 *
 * @author paolo.fagni<at>gmail.com
 */
class ExceptionHandler extends \pff\AModule implements \pff\IBeforeSystemHook {

    /**
     * Executed before the system startup
     *
     * @return mixed
     */
    public function doBeforeSystem() {
        set_exception_handler(array($this,'manageExceptions'));
    }

    public function manageExceptions(\Exception $exception) {
        switch ($exception->getCode()) {
            case  404:
                $view = \pff\FView::create('..' . DS . '..' . DS . 'lib' . DS .'modules' .
                                    DS . 'exception_handler' . DS . 'views' . DS . 'default404_View.php', $this->getController()->getApp());
                $view->set('title', 'Error 404');
                $view->set('message', _('Page not found!'));
                break;
            default:
                $view = \pff\FView::create('..' . DS . '..' . DS . 'lib' . DS .'modules' .
                                    DS . 'exception_handler' . DS . 'views' . DS . 'defaultError_View.php', $this->getController()->getApp());
                $view->set('title', 'Error!');
                $view->set('message', _('An Error Occurred!'));
                break;

        }

        // If we're in dev mode,
        if ($this->getConfig()->getConfigData('development_environment')) {
            $view->set('message_dev', $exception->getMessage());
        }

        $view->render();
    }
}
