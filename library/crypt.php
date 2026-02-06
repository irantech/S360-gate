<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 5/12/2019
 * Time: 11:49 AM
 */

class crypt
{
    private $key;
    private $init_vector_size;
    private $init_vector;
    private $cipher;
    private $mode;

    public function __construct() {
        $this->cipher = MCRYPT_RIJNDAEL_128;
        $this->mode   = MCRYPT_MODE_CBC;
        $this->key    = 'my secret key123';
        $this->init_vector_size = mcrypt_get_iv_size($this->cipher, $this->mode ) ;
        $this->init_vector = mcrypt_create_iv($this->init_vector_size ) ;
    }

    public function encrypt( $data ) {
        $data = mcrypt_encrypt( $this->cipher, $this->key, $data, $this->mode, $this->init_vector ) ;
        $data = base64_encode($data) ;
        return $data;
    }


    public function decrypt ($data) {
        $data = base64_decode($data) ;
        $data = mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $this->init_vector);
        return $data;
    }




}