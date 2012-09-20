<?php

namespace pff\modules;

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
abstract class APasswordChecker {


    /**
     * @abstract
     * @param string $pass Provided password (NOT encrypted)
     * @param string $encryptedPass Encrypted password
     * @return bool
     */
    abstract public function checkPass($pass, $encryptedPass);

}
