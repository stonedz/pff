<?php

namespace pff;

/**
 * Manages helpers
 *
 * @author paolo.fagni<at>gmail.com
 */
class HelperManager
{

    /**
     * Load an helper file
     *
     * @param string $helperName Name of the helper to include
     * @throws \pff\HelperException
     */
    public function load($helperName)
    {
        $helperFilePathUser = ROOT . DS . 'app' . DS . 'helpers' . DS . $helperName . '.php';
        $helperFilePathPff = ROOT . DS . 'lib' . DS . 'helpers' . DS . $helperName . '.php';

        $found = false;

        if (file_exists($helperFilePathUser)) {
            include_once($helperFilePathUser);
            $found = true;
        }
        if (file_exists($helperFilePathPff)) {
            include_once($helperFilePathPff);
            $found = true;
        }

        if (!($found)) {
            throw new \pff\HelperException("Helper not found: " . $helperName);
        }
    }

}
