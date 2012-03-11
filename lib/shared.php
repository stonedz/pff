<?php
// @codeCoverageIgnoreStart

/**
 * General bootstrap operations for the framework.
 *
 * Date: 3/2/12
 *
 * @author paolo.fagni<at>gmail.com
 * @category lib
 * @version 0.1
 */

// Create a new app with the current request
$app = new App($url);
$app->setErrorReporting();
$app->removeMagicQuotes();
$app->unregisterGlobals();
$app->run();
// @codeCoverageIgnoreStop