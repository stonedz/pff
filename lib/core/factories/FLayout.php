<?php

namespace pff;

/**
 * Layouts factory
 *
 * @author paolo.fagni<at>gmail.com
 */
class FLayout {

    /**
     * Gets an ALayout object
     *
     * @static
     * @param string $templateName The name of the template
     * @param App $app
     * @param string $templateType Te type of the template
     * @return \pff\AView
     */
    static public function create($templateName, \pff\App $app, $templateType = null) {
        $standardTemplate = $templateName;
        $mm               = $app->getModuleManager();

        if($mm->isLoaded('mobile_views')) {
            /** @var \pff\modules\MobileViews $mobileViews */
            $mobileViews = $mm->getModule('mobile_views');
            if(($mobileViews->isMobile() && $mobileViews->getAutoMode()) || $mobileViews->getMobileViewOnly()) {
                $tmp          = explode('.', $templateName);
                $tmp[0]      .= '_mobile';
                $templateName = implode('.',$tmp);
            }
        }
        else {
            $mobileViews = null;
        }

        if ($templateType === null) {
            $tmp          = explode('.', $templateName);
            $templateType = $tmp[count($tmp) - 1];
        } else {
            $templateType = strtolower($templateType);
        }

        try {
            return self::loadTemplate($templateName, $app, $templateType);
        }
        catch(\Exception $e) {
            return self::loadTemplate($standardTemplate, $app, $templateType);
        }

    }

    static private function loadTemplate($templateName, \pff\App $app, $templateType) {
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
