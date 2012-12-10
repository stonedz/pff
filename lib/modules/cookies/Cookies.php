<?php

namespace pff\modules;

/**
 * Helper module to manage cookies
 *
 * @author paolo.fagni<at>gmail.com
 */
class Cookies extends \pff\AModule {

    /**
     * If true use encryped cookies
     *
     * @var bool
     */
    private $_useEncryption;

    public function __construct($confFile = 'cookies/module.conf.yaml') {
        $this->loadConfig($this->readConfig($confFile));
    }

    /**
     * Parse the configuration file
     *
     * @param array $parsedConfig
     */
    private function loadConfig($parsedConfig) {
        $this->_useEncryption = $parsedConfig['moduleConf']['useEncryption'];
    }

    /**
     * Sets a cookie in the user's browser
     *
     * @param string $cookieName
     * @param string|null $value The value to store in the cookie
     * @param int|null $expire how many HOURS the cookie will be valid (set to 0 for session time)
     * @return bool
     */
    public function setCookie($cookieName, $value = null, $expire = null) {
        if ($expire !== null) {
            $expire = time() + (60 * 60 * $expire);
        }

        if (setcookie($cookieName, $this->encodeCookie($value), $expire, "/")) {
            return true;
        } else {
            return false;
        }
    }

    private function encodeCookie($value) {
        if ($this->_useEncryption) {
            return $this->getRequiredModules('encryption')->encrypt($value);
        } else {
            return $value;
        }
    }

    private function decodeCookie($value) {
        if ($this->_useEncryption) {
            return $this->getRequiredModules('encryption')->decrypt($value);
        } else {
            return $value;
        }
    }

    /**
     * Check if a cookie is set and returns its content
     *
     * @param string $cookieName
     * @return bool
     * @retrurn string
     */
    public function getCookie($cookieName) {
        if (isset($_COOKIE[$cookieName])) {
            return $this->decodeCookie($_COOKIE[$cookieName]);
        } else {
            return false;
        }
    }

    /**
     * Deletes a cookie
     *
     * @param string $cookieName Name of the cookie to delete
     * @return bool
     */
    public function deleteCookie($cookieName) {
        if (isset($_COOKIE[$cookieName])) {
            if (setcookie($cookieName, null, time() - 6000)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
