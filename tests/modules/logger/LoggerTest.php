<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class LoggerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\modules\Logger
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = pff\modules\Logger::getInstance();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testInitialState() {
        $tmpLoggerArray = $this->object->getLoggers();
        $this->assertInternalType('array', $tmpLoggerArray);
        $this->assertInstanceOf('\\pff\\modules\\ALogger', $tmpLoggerArray[0]);

    }

    public function testX() {
        $this->setExpectedException('\\pff\\modules\\LoggerConfigException');
        $this->object->reset();
        $this->object = \pff\modules\Logger::getInstance('nonononon.yaml');
    }

    public function testFail() {
        $this->assertTrue(true);
    }
}
