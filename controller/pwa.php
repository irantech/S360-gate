<?php

class pwa
{

    /**
     * @var array
     */
    private $appOuwnerCustomers;
    /**
     * @var string[]
     */
    private $unstableCustomers;

    public function __construct() {
        $this->unstableCustomers = [
            '222',
            '4',
        ];
        $this->appOuwnerCustomers = [
            'ir.razdonya.app'
        ];

    }

    public function showLog($param) {
        if (in_array(CLIENT_ID, $this->unstableCustomers)) {
            return $param;
        }
    }


}