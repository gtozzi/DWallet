<?php

/**
* topiq_myum_db
*
* @author     Carlo Denaro <blackout@grayhats.org>
* @author     Gabriele Tozzi <gabriele@tozzi.eu>
* @copyright  2008-2009 TopiQ s.r.l. - www.topiq.it
* @date       02/10/2008
* @package    TOPIQ FRAMEWORK
* @version    1.2.0
*/ 
class topiq_myum_db{
    private     $__name           = "topiq_myum_db";
    private     $__package        = "TOPIQ FRAMEWORK";
    private     $__version        = "1.0.0";
    //
    private        $__dbh;
    // database
    private        $__db;
    // username
    private        $__us;
    // password
    private        $__pa;
    // host
    private        $__ho;
    // pdo driver
    private        $__dri;
    // time of last query
    private        $__time;
    // Should i log queries?
    private        $__logqueries = false;
    // Where to log queries?
    private        $__querylog;
    // Is object connected to database?
    public         $connected;
    // Stores last error
    public         $lasterror;
    // Last statement executed
    public         $sth;
    // Error messages
    public         $strings = array(
        'connecterror' => 'Error connecting database',
        'queryerror'   => 'Query error',
    );
    /**
    * constructor
    *
    * @param     db
    * @param    user
    * @param    pass
    * @param    host
    * @param    driver
    * @param    string lelog: dove loggare l'ultima exception
    * @param    string  elog: dove loggare tutte le exception
    * @return     void
    * @desc     constructor of class
    */
    public function __construct( $db, $user, $pass, $host='localhost', $dri='mysql', $lelog=null, $elog=null ){
        $this->__db         = $db;
        $this->__us         = $user;
        $this->__pa         = $pass;
        $this->__ho         = $host;
        $this->__dri        = $dri;
        $this->__elog       = $elog;
        $this->__lelog      = $lelog;
    }
    /**
    * setLog
    *
    * Sets options for query logging
    *
    * @param bool    enable: True: enable logging, False: disable
    * @param string  logfile: I f passed, set logile path
    */
    public function setLog( $enable, $logfile=null ){
        $this->__logqueries = $enable;
        if( $logfile )
            $this->__querylog = $logfile;
    }
    /**
    * connect
    * @return     void
    * @desc     connect to database
    */
    public function __connect (){
        $this->connected = TRUE;
        try{
            @ $this->__dbh         = new PDO($this->__dri.':host='.$this->__ho.';dbname='.$this->__db, $this->__us, $this->__pa);
            // set UTF8 charset
            @ $this->__query('SET NAMES utf8');
        }catch (PDOException $e) {
            $this->connected = FALSE;
            $usererr = $this->strings['connecterror'];
            $this->__db_error($e);
        }
    }
    /**
    * get connection
    *
    * @return     pdo object
    * @desc     return a pdo connection object
    */
    public function __getConn (){
        return     $this->__dbh;
    }
    /**
    * destructor
    *
    * @return     void
    * @desc     destruct a class
    */
    public function __destruct(){
        $this->__dbh    = null;
    }
    /**
    * Starts a transaction
    */
    public function __beginTransaction(){
        $success = $this->__getConn()->beginTransaction();
        if( ! $success )
            $this->__db_error('Unable to start transaction');
    }
    /**
    * Commits changes
    */
    public function __commit(){
        $success = $this->__getConn()->commit();
        if( ! $success )
            $this->__db_error('Unable to commit transaction');
    }
    /**
    * Rolls back changes
    */
    public function __rollBack(){
        $success = $this->__getConn()->rollBack();
        if( ! $success )
            $this->__db_error('Unable to roll back transaction');
    }
    /**
    * query
    *
    * @param     string query
    * @return     array result
    * @desc     execute a sql query and return array
    */
    public function __query( $query ){
        $t_i=    microtime(true);
        if( @ $a = $this->__getConn()->query($query) ){
            $this->__time= (microtime(true)-$t_i);
            return $a;
        }else{
            try{
                throw new Exception( $this->__getConn()->errorInfo()." QUERY: ".$query );
            }catch(Exception $e) {
                $this->__db_error($e);
            }
        }
    }
    /**
    * run
    *
    * @param  string  query     La query da eseguire. Usare ? come segnaposto per i parametri
    *                           da sostituire. Usare ?? come segnaposto speciale per sostituire
    *                           con tutti i parametri.
    *                             Es: $this->__run('call `mystored`(??)', array(1,2,3,4));
    *                                   equivale a
    *                                 $this->__run('call `mystored`(?,?,?,?)', array(1,2,3,4));
    * @param  array   element   Parametri della query. Gli indici devono essere numerici.
    *                           Il primo indice è 0. Eventuali indici vuoti vengono riempiti
    *                           automatigamente con valori NULL.
    *                             Es: array(2=>'ciao', 5=>'bau') diventa
    *                                 array(0=>NULL,1=>NULL,2=>'ciao',3=>NULL,4=>NULL,5=>'bau')
    * @param  boolean ignoreerr Se false(default), in caso di errore genera l'azione di default
    *                           (messaggio di sistema+die), se true prosegue l'esecuzione.
    *                           Informazioni sull'eventuale errore possono essere ottenute
    *                           tramite $this->lasterror
    * @return boolean           Ritorna TRUE in caso di successo, FALSE in caso di errore
    *                           (se ignoreerr è impostato come TRUE)
    *                           Per leggere i risultati utilizzare $this->sth->(fetch|fechAll|...)
    *                           Per ottenere il numero di risultati trovati $this->sth->rowCount
    *                           il fetchMode viebe impostato di default su PDO::FETCH_ASSOC
    *                           (vedere la documentazione di PDO al riguardo:
    *                             http://www.php.net/manual/en/class.pdostatement.php)
    * @desc   Esegue una query
    */
    public function __run( $query, $elements=array(), $ignoreerr=false ){

        //Chiudo il cursore della vecchia query
        if( is_object($this->sth) )
            $this->sth->closeCursor();

        //Converto eventuali oggetti datetime di $elements in stringa
        foreach($elements as $k=>&$v)
            if( is_object($v) && $v instanceof DateTime)
                $v = $v->format('Y-m-d H:i:s');
        unset($v);

        //Rimuovo eventuali parametri nominali non utilizzati
        foreach( $elements as $k => $v )
            if( is_string($k) && ! preg_match( '/:'.preg_quote($k).'/', $query ) )
                unset($elements[$k]);

        //Popolo gli indici vuoti di $elements se è presente almeno un parametro
        //numerico
        $keys = array_keys($elements);
        $lastkey = null;
        foreach( $keys as $k)
            if( is_int($k) && ( $k > $lastkey || $lastkey === null ) )
                $lastkey = $k;
        if( $lastkey !== null )
            for( $i=0; $i<=$lastkey; $i++ )
                if( ! array_key_exists($i, $elements) )
                    $elements[$i] = null;
        ksort($elements);

        //Sostituisco il pattern speciale ??
        if( strpos($query, '??') )
            $query = str_replace( '??', @implode(',', @array_fill(0,count($elements),'?')), $query );

        //Loggo la query se specificato in config
        if( $this->__logqueries )
            $this->__log_query( $query, $elements );

        $t_i = microtime(true);
        if( @ $this->sth = $this->__getConn()->prepare( $query ) ){

            //Eseguo la query
            if ( @ $this->sth->execute($elements) == true ) {
                $this->__time = microtime(true) - $t_i;
                $this->sth->setFetchMode(PDO::FETCH_ASSOC);
                return true;
            }elseif( $ignoreerr ) {
                $this->lasterror = $this->sth->errorInfo();
                return false;
            }else{
                try{
                    throw new Exception( $this->strings['queryerror']." ".print_r( $this->sth->errorInfo(), TRUE ) );
                }catch(Exception $e) {
                    $this->__db_error($e);
                }
            }

        }elseif( $ignoreerr ) {
            $this->lasterror = $sth->errorInfo();
            return false;
        }else{
            try{
                throw new Exception( print_r( $sth->errorInfo() ) );
            }catch(Exception $e) {
                $this->__db_error($e);
            }
        }
    }
    /**
    * getTime
    *
    * @return    double time
    * @desc        ritorna il tempo impiegato dalle query
    */
    public function __getTime(){
        return $this->__time;
    }

    /**
    * Dato l'indice di un parametro nell'array, ritorna il nome da utilizzare
    * quando quetso viene bindato come parametro
    *
    * @param mixed  key: La chiave del parametro
    *
    * @return mixed  La nuova chiave da utilizzare
    */
    private function __getBindName($key) {
        return is_int($key) ? $key+1 : ":$key";
    }

    /**
    * log_query
    *
    * @return  NULL
    * @desc    logga le query in un file di testo
    */
    private function __log_query( $query, $elements ) {
    
        if( ! $fd = @ fopen( $this->__querylog, 'a' ) )
            return NULL;
    
        $log = $query;
        if( count($elements) )
            foreach( $elements as $name => $element ) {
                if( $element == NULL )
                    $element = 'NULL';
                elseif( is_string( $element ) )
                    $element = '\'' . addslashes($element) . '\'';
                if( is_int($name) )
                    $log = preg_replace( '/\?/', $element, $log, 1 );
                else
                    $log = preg_replace( '/:'.preg_quote($name).'/', $element, $log, 1 );
            }
        $log .= "\n";
    
        fwrite($fd, $log);
        fclose($fd);

        return NULL;
    }

    /**
    * db_error
    *
    * @param exception e: L'errore da loggare
    */
    private function __db_error( $e ) {
        $out = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
                <title>Error</title>
                <style>
                    body {
                        background: #aaaaaa;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
            <br/>
            <br/>
            We are sorry. Internal server error occourred. Please try again later.<br/>
            </body>
            </html>
        ';

        echo $out;

        if( $this->__lelog || $this->__elog ) {
            //Non potendo fare affidamento sul database, devo loggare l'accaduto in un file di testo

            if( $this->__elog )
                $fd = @ fopen( $this->__elog, 'a' );

            if( $this->__lelog )
                $fa = @ fopen( $this->__lelog, 'w' );

            $log  = "\n-------------------------------------------------------------------------\n";
            $log .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
            $log .= "------------------------\n";
            $log .= "Exception dump:\n";

            if( $fd )
                fwrite($fd, $log);
                fwrite($fd, print_r($e,TRUE));
            if( $fa )
                fwrite($fa, $log);
                fwrite($fa, print_r($e,TRUE));

            $log = "\n------------------------\n";

            if( $fd )
                fwrite($fd, $log);
            if( $fa )
                fwrite($fa, $log);

            $log .= "Globals dump:\n";

            if( $fd )
                fwrite($fd, $log);
                fwrite($fd, print_r($GLOBALS,TRUE));
            if( $fa )
                fwrite($fa, $log);
                fwrite($fa, print_r($GLOBALS,TRUE));

            $log  = "\n-------------------------------------------------------------------------\n\n\n\n";

            if( $fd )
                fwrite($fd, $log);
            if( $fa )
                fwrite($fa, $log);

            if( $fd )
                fclose($fd);
            if( $fa )
                fclose($fa);

        }
        exit(1);
    }
}
?>