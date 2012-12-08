<?php

namespace pff;
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class FLayout
{

    static public function create($templateName, \pff\App $app, $templateType = null)
    {

        if ($templateType === null) {
            $tmp = explode('.', $templateName);
            $templateType = $tmp[count($tmp) - 1];
        } else {
            $templateType = strtolower($templateType);
        }

        switch ($templateType) {
            case 'php':
                return new \pff\LayoutPHP($templateName, $app);
                break;
            case 'tpl':
            case 'smarty':
                return new \pff\LayoutSmarty($templateName, $app);
                break;
            default:
                return new \pff\LayoutPHP($templateName, $app);
                break;

        }
    }
}
