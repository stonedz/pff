<?php

namespace pff\modules;

/**
 *
 * @author paolo.fagni<at>gmail.com
 */
class md5PasswordChecker extends \pff\modules\APasswordChecker {

//    private $_modelName;
//    private $_getUsernameMethod;
//    private $_getPasswordMethod;
//
//    public function __construct($model, $getUser, $getPassword) {
//        $this->_modelName         = $model;
//        $this->_getUsernameMethod = $getUser;
//        $this->_getPasswordMethod = $getPassword;
//    }

    public function checkPass($pass, $encryptedPass) {
        if(md5($pass) == $encryptedPass) {
            return true;
        }
        else {
            return false;
        }
    }

}