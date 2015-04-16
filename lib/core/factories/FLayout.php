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
     * @return \pff\ALayout
     */
    static public function create($templateName, \pff\App $app, $templateType = null) {
        $standardTemplate = $templateName;


        if ($templateType === null) {
            $tmp          = explode('.', $templateName);
            $templateType = $tmp[count($tmp) - 1];
        } else {
            $templateType = strtolower($templateType);
        }

        return self::loadTemplate($templateName, $app, $templateType);


//        try {
//            return self::loadTemplate($templateName, $app, $templateType);
//        }
//        catch(\Exception $e) {
//            return self::loadTemplate($standardTemplate, $app, $templateType);
//        }
    }

    static private function loadTemplate($templateName, \pff\App $app, $templateType) {
        $mm = $app->getModuleManager();

        switch ($templateType) {
            case 'php':
                $templateName = self::checkMobile($templateName, $mm, 'php');
                return new \pff\LayoutPHP($templateName, $app);
                break;
            case 'tpl':
            case 'smarty':
                $templateName = self::checkMobile($templateName, $mm, 'smarty');
                return new \pff\LayoutSmarty($templateName, $app);
                break;
            default:
                $templateName = self::checkMobile($templateName, $mm, 'php');
                return new \pff\LayoutPHP($templateName, $app);
                break;

        }
    }

    /**
     * @param $templateName
     * @param $mm
     * @return array
     */
    private static function checkMobile($templateName, $mm, $type) {
        if ($mm->isLoaded('mobile_views')) {

            /** @var \pff\modules\MobileViews $mobileViews */
            $mobileViews = $mm->getModule('mobile_views');
            if ($mobileViews->isMobile() || $mobileViews->getMobileViewOnly()) {
                $tmp = explode('.', $templateName);
                $tmp[0] .= '_mobile';
                $tempTemplateName = implode('.', $tmp);

                if($type == 'php') {
                    $templatePath = ROOT . DS . 'app' . DS . 'views' . DS .  $tempTemplateName;
                }
                else{ // smarty
                    $templatePath = ROOT . DS . 'app' . DS . 'views' . DS . 'smarty' . DS . 'templates' . DS . $tempTemplateName;
                }

                if (file_exists($templatePath)) {
                    return $tempTemplateName;
                }
                else {
                    return $templateName;
                }
            }
            else {
                return $templateName;
            }

        }
        else {
            return $templateName;
        }
    }
}
