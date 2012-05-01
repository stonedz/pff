<?php

namespace pff\modules;


/**
 * pff logger module
 *
 * Implements the singleton pattern.
 *
 * @author paolo.fagni<at>gmail.com
 */

class Logger extends \pff\AModule{

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

    public function __construct($confFile = 'logger.conf.yaml') {
        $this->loadConfig($confFile);
    }

    public function loadConfig($confFile) {
        $yamlParser = new \Symfony\Component\Yaml\Parser();
        $confPath   = ROOT . DS . 'lib' . DS . 'modules' . DS . 'logger' . DS . $confFile;
        if(file_exists($confPath)) {
            try{
                $conf = $yamlParser->parse(file_get_contents($confPath));
            }catch( \Symfony\Component\Yaml\Exception\ParseException $e ) {
                throw new \pff\ModuleException("Unable to parse module configuration
                                            file for Logger module: ".$e->getMessage());
            }

            try{
                foreach ($conf['moduleConf']['activeLoggers'] as $logger){
                    $tmpClass         = new \ReflectionClass('\\pff\\modules\\'. (string)$logger['class']);
                    $this->_loggers[] = $tmpClass->newInstance();
                }
            }
            catch(\ReflectionException $e){
                throw new \pff\modules\LoggerException('Logger creation failed: '.$e->getMessage());
            }
        }
        else {
            throw new \pff\modules\LoggerConfigException ("Logger Module configuration file not found: " .$confFile);
        }
    }

    public function __destruct() {
        if(isset($this->_loggers[0])){
            foreach ($this->_loggers as $logger){
                unset($logger);
            }
            $this->reset();
        }
    }

    /**
     * Returns a Logegr instance
     *
     * @return Logger
     */
    public static function getInstance($confFile = 'logger.conf.yaml') {
        if (!isset(self::$_instance)) {
            $className       = __CLASS__;
            self::$_instance = new $className($confFile);
        }
        return self::$_instance;
    }

    /**
     * Deletes current instance
     *
     * @return void
     */
    public static function reset() {
        self::$_instance = NULL;
    }

    /**
     * Forbids instance to be cloned
     *
     * @return void
     */
    public function __clone() {
        return;
    }

    /**
     * Main logging function. Logs a message with a level.
     *
     * @param string $message Message to log
     * @param int $level Log level, 0 = low 3 = high
     * @throws \pff\modules\LoggerException
     */
    public function log($message, $level = 0) {
        foreach ($this->_loggers as $logger){
            try{
                $logger->logMessage($message, $level);
            }
            catch(\pff\modules\LoggerException $e){
                throw $e;
            }
        }
    }

    public function getLoggers() {
        return $this->_loggers;
    }
}

