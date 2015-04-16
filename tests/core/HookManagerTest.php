<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class HookManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \pff\HookManager
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp() {
        $conf         = new \pff\Config();
        $this->object = new \pff\HookManager($conf);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
    }

    public function testInitialStateIsValid() {
        $this->assertEmpty($this->object->getBeforeController());
        $this->assertEmpty($this->object->getAfterController());
    }

    public function testRegisterABeforeProvider() {
        $stub = $this->getMock('\\pff\\IBeforeHook');
        $stub->expects($this->any())
             ->method('doBefore')
             ->will($this->returnValue('done'));

        $this->object->registerHook($stub);

        $listOfHooks = $this->object->getBeforeController();
        $this->assertNotEmpty($listOfHooks);
        $this->assertEmpty($this->object->getAfterController());
        $this->assertEmpty($this->object->getBeforeSystem());
        $this->assertEquals('done', $listOfHooks[0]->doBefore());
    }

    public function testRegisterAnAfterProvider() {
        $stub = $this->getMock('\\pff\\IAfterHook');
        $stub->expects($this->any())
            ->method('doAfter')
            ->will($this->returnValue('done'));

        $this->object->registerHook($stub);

        $listOfHooks = $this->object->getAfterController();
        $this->assertNotEmpty($listOfHooks);
        $this->assertEquals('done', $listOfHooks[0]->doAfter());
    }

    public function testRegisterABeforeSystemProvider() {
        $stub = $this->getMock('\\pff\\IBeforeSystemHook');
        $stub->expects($this->any())
            ->method('doBeforeSystem')
            ->will($this->returnValue('done'));

        $this->object->registerHook($stub);

        $listOfHooks = $this->object->getBeforeSystem();
        $this->assertNotEmpty($listOfHooks);
        $this->assertEquals('done', $listOfHooks[0]->doBeforeSystem());
    }

    public function testFailsToRegisterAnEmptyProvider() {
        $this->setExpectedException('\\pff\\HookException');
        $stub = $this->getMock('\\pff\\IHookProvider');
        $this->object->registerHook($stub);
    }

}