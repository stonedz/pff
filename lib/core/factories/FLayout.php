<?php

namespace pff;
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class FLayout  {

    static public function create($templateName, \pff\App $app, $templateType = null)
    {

        if ($templateType === null) {
            $templateType = end(explode('.', $templateName));
        } else {
            $templateType = strtolower($templateType);
        }

        switch ($templateType) {
            case 'php':
                return new \pff\LayoutPHP($templateName, $app);
                break;
//            case 'tpl':
//            case 'smarty':
//                return new \pff\ViewSmarty($templateName, $app);
//                break;
            default:
                return new \pff\LayoutPHP($templateName, $app);
                break;

        }
    }
}
