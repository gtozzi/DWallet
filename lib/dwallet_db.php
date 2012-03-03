<?php

/**
* Handles Dwallet database
*
* @author     Gabriele Tozzi <gabriele@tozzi.eu>
* @date       03.03.2012
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

}
?>
