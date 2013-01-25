<?php
/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class EncryptionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \pff\modules\Encryption
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \pff\modules\Encryption();
    }

    public function testEncryption()
    {
        $string = "A string";
        $encryptedString = $this->object->encrypt($string);
        $decryptedString = $this->object->decrypt($encryptedString);
        $this->assertNotEquals($string, $encryptedString);
        $this->assertEquals($string, $decryptedString);
    }
}
