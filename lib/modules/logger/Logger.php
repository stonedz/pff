<?php

namespace pff\modules;

define ('CONF_FILE_NAME', ROOT . DS . 'lib' . DS . 'modules' . DS . 'logger' . DS .'logger.conf.yaml');

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

    public function __construct() {
        $yamlParser     = new \Symfony\Component\Yaml\Parser();
        try{
            $conf = $yamlParser->parse(file_get_contents(CONF_FILE_NAME));
        }catch( \Symfony\Component\Yaml\Exception\ParseException $e ) {
            throw new \pff\ModuleException("Unable to parse module configuration
                                                    file for Logger module: ".$e->getMessage());
        }

        //$conf = simplexml_load_file(CONF_FILE_NAME);

        try{
            foreach ($conf['moduleConf']['activeLoggers'] as $logger){
                $tmpClass= new \ReflectionClass('\\pff\\modules\\'. (string) $logger['class']);
                $this->_loggers[] = $tmpClass->newInstance();
            }
        }
        catch(\ReflectionException $e){
            throw new \Exception('Logger creation failed: '.$e->getMessage());
        }

    }

    public function __destruct() {
        foreach ($this->_loggers as $logger){
            unset($logger);
        }
        $this->reset();
    }

    /**
     * Returns a Logegr instance
     *
     * @return Logger
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            $c = __CLASS__;
            self::$_instance = new $c;
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
     */
    public function log($message, $level = 0){
        foreach ($this->_loggers as $logger){
            try{
                $logger->logMessage($message, $level);
            }
            catch(LoggerException $e){
                throw $e;
            }
        }
    }
}
