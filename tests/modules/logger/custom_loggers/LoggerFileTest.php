<?php
/**
 * LoggerFile test class
 *
 * @author paolo.fagni<at>gmail.com
 */
class LoggerFileTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\modules\LoggerFile
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new pff\modules\LoggerFile();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testInitialStateIsOk() {
        $this->assertNull($this->object->getFp());
    }

    public function testFilePointer() {
        $this->assertInternalType('resource', $this->object->getLogFile());

    }

}
