<?php
// @codeCoverageIgnoreStart

/**
 * General bootstrap operations for the framework.
 *
 * @author paolo.fagni<at>gmail.com
 */

// Create a new app with the current request
$cfg         = new \pff\Config();
$hm          = new \pff\HookManager($cfg);
$mm          = new \pff\ModuleManager($cfg);
$helpManager = new \pff\HelperManager();

$app = new \pff\App($url, $cfg, $mm, $hm);
$app->setHelperManager($helpManager);
$app->setErrorReporting();
$app->removeMagicQuotes();
$app->unregisterGlobals();
// @codeCoverageIgnoreStop