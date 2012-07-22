<?php

/**
 * Test for Config
 * @author paolo.fagni<at>gmail.com
 */
class ConfigTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\Config
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new \pff\Config();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testConfigurationIsNotEmptyAtStartup() {
        $this->assertNotEmpty($this->object->getConfig());
    }

    public function testGetConfigFailsWithInvalid() {
        $this->setExpectedException('\\pff\\ConfigException');
        $this->object->getConfigData('NoIDoNotExistxxxxx');
    }

    public function testGetAconfigurationValue() {
        $this->assertTrue(is_bool($this->object->getConfigData('development_environment')));
    }

    public function testSetAConfigurationValue() {
        $this->object->setConfig('aTestValue', 12);
        $this->assertEquals($this->object->getConfigData('aTestValue'), 12);
    }

    public function testSetAConfigurationFailsWithoutAString() {
        $this->setExpectedException('\\pff\\ConfigException');
        $this->object->setConfig(array(), 12);
    }

    public function testGetConfigReturnsArrayWithNoParamaters() {
        //$this->assertTrue(is_array($this->object->getConfig()));
        $this->assertInternalType('array', $this->object->getConfigData());
    }

    public function testLoadConfigFailsWithInexistantFile() {
        $this->setExpectedException('\\pff\\ConfigException');
        $this->object->loadConfig('nonono', 'config');
    }
}
