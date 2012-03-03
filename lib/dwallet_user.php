<?php

/**
* @file dwallet_user.php DWallet user manager
*
* @author Gabriele Tozzi <gabriele@tozzi.eu>
* @date   03.03.2012
*
* This file is part of DWallet
*
* DWallet is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.

* DWallet is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
*/

class dwallet_user
{
    /** User ID */
    private $_uid;
    /** Encryption password */
    private $_encKey;

    public function __construct() {
        $this->logout();
    }

    public function __toString()
    {
        return (string)$this->_uid;
    }

    public function login($uid, $encKey)
    {
        $this->_uid = $uid;
        $this->_encKey = $encKey;
    }

    public function getUid()
    {
        return $this->_uid;
    }
    public function getKeyPwd()
    {
        return $this->_encKey;
    }

    public function isAuthenticated()
    {
        return $this->_uid ? true : false;
    }

    public function logout()
    {
        $this->_uid = null;
        $this->_encKey = null;
    }

}

?>
