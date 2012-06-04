<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class AutomaticHeaderFooterTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\modules\AutomaticHeaderFooter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new \pff\modules\AutomaticHeaderFooter();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testReadConfigFile(){
        $conf = $this->object->readConfig();
        $this->assertArrayHasKey('moduleConf',$conf);
    }

    public function testReadConfigFailsWithInvalidFile() {
        $this->setExpectedException('\\pff\\modules\\AutomaticHeaderFooterException');
        $this->object->readConfig('i_do_not_exist_and_never_will.conf.jdjd');
    }

}
