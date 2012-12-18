<?php

namespace pff\modules;

/**
 * Helper module to send mail
 *
 * @author marco.sangiorgi<at>neropaco.net
 */

require_once(ROOT . DS . 'lib/vendor/swiftmailer/swiftmailer/lib/swift_init.php');

class Mail extends \pff\AModule {

    private $mailer;

    private $transport;

    private $message;

    public function __construct($confFile = 'mail/module.conf.yaml') {
        $this->loadConfig($this->readConfig($confFile));

        $this->mailer = new \Swift_Mailer($this->transport);
    }

    /**
     * Parse the configuration file
     *
     * @param array $parsedConfig
     */
    private function loadConfig($parsedConfig) {

        if (isset($parsedConfig['moduleConf']['Type']) && $parsedConfig['moduleConf']['Type'] == "smtp") {

            $this->transport = \Swift_SmtpTransport::newInstance();

            if (isset($parsedConfig['moduleConf']['Host']) && $parsedConfig['moduleConf']['Host'] != "") {
                $this->transport->setHost($parsedConfig['moduleConf']['Host']);
            }

            if (isset($parsedConfig['moduleConf']['Port']) && $parsedConfig['moduleConf']['Port'] != "") {
                $this->transport->setPort($parsedConfig['moduleConf']['Port']);
            }

            if (isset($parsedConfig['moduleConf']['Username']) && $parsedConfig['moduleConf']['Username'] != "") {
                $this->transport->setUsername($parsedConfig['moduleConf']['Username']);
            }

            if (isset($parsedConfig['moduleConf']['Password']) && $parsedConfig['moduleConf']['Password'] != "") {
                $this->transport->setPassword($parsedConfig['moduleConf']['Password']);
            }

            if (isset($parsedConfig['moduleConf']['Encryption']) && $parsedConfig['moduleConf']['Encryption'] != "") {
                $this->transport->setEncryption($parsedConfig['moduleConf']['Encryption']);
            }

        } elseif (isset($parsedConfig['moduleConf']['Type']) && $parsedConfig['moduleConf']['Type'] == "sendmail") {

            $this->transport = \Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        } else {

            $this->transport = \Swift_MailTransport::newInstance();

        }

    }

    public function sendMail($to, $from, $fromName, $subject, $body, $attachment = null) {
        $this->message = new \Swift_Message();
        $this->message->setTo($to);
        $this->message->setFrom(array($from => $fromName));
        $this->message->setSubject($subject);
        $this->message->setBody($body);
        //$this->message->attach($attachment);
        return $this->mailer->send($this->message);
    }
}
