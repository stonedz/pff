<?php

namespace pff;

/**
 * Views Factory
 *
 * @author paolo.fagni<at>gmail.com
 */
class FView {

    /**
     * Gets an AView object
     *
     * @static
     * @param string $templateName The name of the template
     * @param string $templateType Te type of the template
     * @return \pff\AView
     */
    static public function create($templateName, $templateType = null) {
        if($templateType === null) {
            $templateType = end(explode('.',$templateName));
        }
        else {
            $templateType = strtolower($templateType);
        }

        switch($templateType) {
            case 'php':
                return new \pff\ViewPHP($templateName);
                break;
            case 'tpl':
            case 'smarty':
                return new \pff\ViewSmarty($templateName);
                break;
            default:
                return new \pff\ViewPHP($templateName);
                break;

        }
    }
}
