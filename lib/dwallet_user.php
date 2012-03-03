<?php

/**
* DWallet user manager
*/

class dwallet_user
{
    /** User ID */
    private $_uid;
    /** Encryption password */
    private $_encPwd;

    public function __construct() {
        $this->logout();
    }

    public function __toString()
    {
        return (string)$this->_uid;
    }

    public function login($uid, $encPwd)
    {
        $this->_uid = $uid;
        $this->_encPwd = $encpwd;
    }

    public function getUid()
    {
        return $this->_uid;
    }
    public function getEncPwd()
    {
        return $this->_encPwd;
    }

    public function isAuthenticated()
    {
        return $this->_uid ? true : false;
    }

    public function logout()
    {
        $this->_uid = null;
        $this->_encPwd = null;
    }

}

?>
