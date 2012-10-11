<?php

namespace pff\modules;

/**
 * Helper module to manage cookies
 *
 * @author paolo.fagni<at>gmail.com
 */
class Mail extends \pff\AModule
{

    /**
     * If true use encryped cookies
     *
     * @var bool
     */
    //private $_useEncryption;
    private $phpmailer;

    public function __construct($confFile = 'mail/module.conf.yaml')
    {
        $this->phpmailer = new \PHPMailerLite();
        $this->loadConfig($this->readConfig($confFile));
    }

    /**
     * Parse the configuration file
     *
     * @param array $parsedConfig
     */
    private function loadConfig($parsedConfig)
    {
        if(isset($parsedConfig['moduleConf']['Host']) && $parsedConfig['moduleConf']['Host'] != ""){
            $this->phpmailer->Hostname = $parsedConfig['moduleConf']['Host'];
        }
        //$this->phpmailer->
        //$this->_useEncryption = $parsedConfig['moduleConf']['useEncryption'];

    }
}
