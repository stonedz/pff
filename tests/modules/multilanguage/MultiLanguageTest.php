<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class MultiLanguageTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \pff\modules\MultiLanguage
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \pff\modules\MultiLanguage();
    }

    public function testProcessUrlWithLanguage()
    {
        $tmpUrl = $this->object->processUrl('it/controller/action/param1');
        $this->assertEquals('controller/action/param1', $tmpUrl);
        $this->assertEquals('it', $this->object->getSelectedLanguage());
    }

    public function testProcessUrlWithNoLanguage()
    {
        $tmpUrl = $this->object->processUrl('controller/action/param1');
        $this->assertEquals('controller/action/param1', $tmpUrl);
        $this->assertNull($this->object->getSelectedLanguage());
    }

//    public function testDefaultLanguage() {
//       $this->object->chooseLanguage();
//    }
}
