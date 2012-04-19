<?php
/**
 * ModuleManager test suite
 *
 * @author paolo.fagni<at>gmail.com
 */
class ModuleManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\ModuleManager
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp() {
        $conf = new \pff\Config();
        $this->object = new \pff\ModuleManager($conf);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testFail() {
        $this->assertTrue(true);
    }

}
