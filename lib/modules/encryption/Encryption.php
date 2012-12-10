<?php

namespace pff\modules;

/**
 * Helper module to encrypt/decrypt content
 *
 * @author paolo.fagni<at>gmail.com
 */
class Encryption extends \pff\AModule {

    const MODE = MCRYPT_MODE_CBC;

    /**
     * The cypher method to be used
     *
     * @var string
     */
    private $_cypher;

    /**
     * md5 of the key used to encrypt/decrypt data
     *
     * @var string
     */
    private $_key;

    public function __construct($confFile = 'encryption/module.conf.yaml') {
        $this->loadConfig($this->readConfig($confFile));
    }

    /**
     * Parse the configuration file
     *
     * @param array $parsedConfig
     */
    private function loadConfig($parsedConfig) {
        $this->_cypher = $parsedConfig['moduleConf']['cypher'];
        $this->_key    = md5($parsedConfig['moduleConf']['key']);
    }

    /**
     * Encrypts a text
     *
     * @param string $plaintext the text to encrypt
     * @return string
     */
    public function encrypt($plaintext) {
        $td = mcrypt_module_open($this->_cypher, '', self::MODE, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->_key, $iv);
        $crypttext = mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        return base64_encode($iv . $crypttext);
    }

    /**
     * Decrypt a previously encrypted text
     *
     * @param string $crypttext
     * @return string
     */
    public function decrypt($crypttext) {
        $crypttext = base64_decode($crypttext);
        $plaintext = '';
        $td        = mcrypt_module_open($this->_cypher, '', self::MODE, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv) {
            mcrypt_generic_init($td, $this->_key, $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
    }
}