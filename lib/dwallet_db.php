<?php

/**
* Handles Dwallet database
*
* @author     Gabriele Tozzi <gabriele@tozzi.eu>
* @date       03.03.2012
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
class dwallet_db extends topiq_myum_db {

    /** The current user object instance */
    private $_user;
    /** The current user IP address */
    private $_ip;

    /**
    * constructor
    *
    * @param    ip Current session's IP
    * @param    user instance of dwallet_user for the current user
    * @param    db db name
    * @param    uname user name
    * @param    pass password
    * @param    host db host
    * @param    driver db sriver
    * @param    string lelog: dove loggare l'ultima exception
    * @param    string  elog: dove loggare tutte le exception
    * @return     void
    * @desc     constructor of class
    */
    public function __construct( $ip, $user, $db, $uname, $pass, $host='localhost', $dri='mysql', $lelog=null, $elog=null ){
        $this->_user = $user;
        $this->_ip = $ip;
        parent::__construct($db, $uname, $pass, $host, $dri, $lelog, $elog);
    }

    /**
    * Authenticates an user
    *
    * @param string    email: User's email
    * @param string password: User's password
    *
    * @return int: User ID, False on failure
    */
    public function login( $email, $pwd ) {
        $q = '
            SELECT `id`
            FROM `users`
            WHERE `email` = ?
                AND `password` = SHA1(?)
        ';
        $p = array($email, $pwd);

        $this->__run($q,$p);
        $ret = $this->sth->fetch();
        if($ret)
            return (int)$ret['id'];
        else
            return false;
    }

}
?>
