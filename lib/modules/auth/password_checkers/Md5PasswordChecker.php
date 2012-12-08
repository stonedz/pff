<?php

namespace pff\modules;

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class Md5PasswordChecker extends APasswordChecker
{

    public function checkPass($pass, $encryptedPass)
    {
        if (md5($pass) == $encryptedPass) {
            return true;
        } else {
            return false;
        }
    }

}