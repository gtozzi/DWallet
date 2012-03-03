<?php

/**
* Encodes / Decodes a password for storage in DB text field
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
class dwallet_encoder {

    /** The algorithm to use */
    private $_alg;
    /** The inizialization vector */
    private $_IV;
    /** The mode */
    private $_mode;

    /**
    * Constructor
    *
    * @param    string  alg: MCrypt algorithm to use
    * @param    string mode: MCrypt mode
    */
    public function __construct( $alg, $mode, $IV=null ) {
        $this->_alg = $alg;
        $this->_mode = $mode;
        if( $IV !== null )
            $this->_IV = $IV;
        else
            $this->_IV = mcrypt_create_iv(mcrypt_get_iv_size($alg, $mode), MCRYPT_RAND);
    }

    /**
    * Encrypts data
    *
    * @param    string data: the data to be encrypted
    * @param    string  key: the encryption key
    *
    * @return   array: 0=>The encrypted data, non-binary, 1=>The IV, base64
    */
    public function encrypt( $data, $key ) {
        // First pad data
        $enc = $this->addPadding($data);
        // Then build an array with has for decryption checksum
        $enc = array(
            'data' => $enc,
            'hash' => sha1($enc),
        );
        // Then convert array to string using json
        $enc = json_encode($enc);
        // Now do real encryption
        $enc = mcrypt_encrypt($this->_alg, $key, $enc, $this->_mode, $this->_IV);
        // Finally add base64 armor
        $enc = base64_encode($enc);

        return array($enc, base64_encode($this->_IV));
    }

    /**
    * Decrypts data
    *
    * @param    string origin: the encrypted data to be decrypted
    * @param    string    key: the encryption key
    * @param    string    IV:  the Inizialization venctor for decryption, base64
    *
    * @return   string: The decripted data
    * @throws   DecriptionException when decryption fails
    */
    public function decrypt( $origin, $key, $IV=null ) {
        if( ! $IV )
            $IV = $this->_IV;
        else
            $IV = base64_decode($IV);
        // First remove base64 armor
        $dec = base64_decode($origin);
        // Now do real decryption
        $dec = mcrypt_decrypt($this->_alg, $key, $dec, $this->_mode, $IV);
        // Reconstruct array from json
        $dec = json_decode($dec, true);
        // Check the hash
        if( $dec['hash'] != sha1($dec['data']) )
            throw new DecriptionException('Hash mismatch');
        // Unpad data
        $dec = $this->stripPadding($dec['data']);

        return $dec;
    }

    /**
    * Adds PKCS7 compatible padding
    */
    private function addPadding($string){
        $blocksize = mcrypt_get_block_size($this->_alg, $this->_mode);
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
    * Strips PKCS7 compatible padding
    */
    private function stripPadding($string){
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if(preg_match("/$slastc{".$slast."}/", $string)){
            $string = substr($string, 0, strlen($string)-$slast);
            return $string;
        } else {
            return false;
        }
    }

}

class DecriptionException extends Exception {

}
