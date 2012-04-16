<?php

namespace pff\modules;

/**
 * Abstract class that must be exteded by any logger.
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class ALogger {
    
    // Log levels
    const LVL_NORM = 0;
    const LVL_ERR = 1;
    const LVL_FATAL = 2;
    
    /**
     * Log level names
     * 
     * @var string[]
     */
    protected $_levelNames;
    
    /**
     * Debug mode
     *
     * @todo To be implemented
     * @var bool
     */
    protected $_debugActive;
    
    public function __construct($debugActive = false) {
        $this->_debugActive = $debugActive;
        
        $this->_levelNames[self::LVL_NORM] = 'NORMAL';
        $this->_levelNames[self::LVL_ERR] = 'ERROR';
        $this->_levelNames[self::LVL_FATAL] = 'FATAL';
    }
    
    /**
     * Logs a message
     * 
     * @param string $message Message to log
     * @param int $level Level to log the message
     */
    abstract public function logMessage($message, $level = 0);
    
}
