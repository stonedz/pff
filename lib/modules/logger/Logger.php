<?php

namespace pff\modules;


/**
 * pff logger module
 *
 * Implements the singleton pattern.
 *
 * @author paolo.fagni<at>gmail.com
 */

class Logger extends \pff\AModule implements \pff\IConfigurableModule
{

    /**
     * Private Logger instance (Singleton)
     *
     * @var Logger
     */
    private static $_instance;

    /**
     * Array of loggers registered.
     *
     * @var \pff\modules\ALogger[]
     */
    private $_loggers;

    public function __construct($confFile = 'logger/logger.conf.yaml')
    {
        $this->loadConfig($confFile);
    }

    /**
     * Loads the configuration
     *
     * @param string $confFile Path relative to modules/ of the configuration file
     * @return mixed|void
     * @throws \pff\modules\LoggerException
     */
    public function loadConfig($confFile)
    {
        $conf = $this->readConfig($confFile);
        try {
            foreach ($conf['moduleConf']['activeLoggers'] as $logger) {
                $tmpClass = new \ReflectionClass('\\pff\\modules\\' . (string)$logger['class']);
                $this->_loggers[] = $tmpClass->newInstance();
            }
        } catch (\ReflectionException $e) {
            throw new \pff\modules\LoggerException('Logger creation failed: ' . $e->getMessage());
        }

    }

    public function __destruct()
    {
        if (isset($this->_loggers[0])) {
            foreach ($this->_loggers as $logger) {
                unset($logger);
            }
            $this->reset();
        }
    }

    /**
     * Returns a Logegr instance
     *
     * @param string $confFile
     * @return Logger
     */
    public static function getInstance($confFile = 'logger/logger.conf.yaml')
    {
        if (!isset(self::$_instance)) {
            $className = __CLASS__;
            self::$_instance = new $className($confFile);
        }
        return self::$_instance;
    }

    /**
     * Deletes current instance
     *
     * @return void
     */
    public static function reset()
    {
        self::$_instance = NULL;
    }

    /**
     * Forbids instance to be cloned
     *
     * @return void
     */
    public function __clone()
    {
        return;
    }

    /**
     * Main logging function. Logs a message with a level.
     *
     * @param string $message Message to log
     * @param int $level Log level, 0 = low 3 = high
     * @throws \Exception|LoggerException
     * @return void
     */
    public function log($message, $level = 0)
    {
        foreach ($this->_loggers as $logger) {
            try {
                $logger->logMessage($message, $level);
            } catch (\pff\modules\LoggerException $e) {
                throw $e;
            }
        }
    }

    public function getLoggers()
    {
        return $this->_loggers;
    }
}

