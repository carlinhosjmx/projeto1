<?php

namespace App\Classes\Paypal;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class ApiConfig{

    public $api;

    public function __construct(){
        $this->api = new ApiContext(
            new OAuthTokenCredential(
                'AUlysqZ8Y9sx2cV5VOzpKaOXcf28rriWm8lWrz_sa2xpHvWRfPwnqGAWtBY6hvGJKOMGkwMOGwgLbTQS',
                'EEcWFNkHwxJIc85tM13JKYotrS9o-4nHkqLPOdx726uLinbgApC2IEa2mzVjngZ28MlSMDLx_exu95rD'
            )
        );
    }

    public function config(){
        $this->api->setConfig(
            [
                'mode' => 'sandbox',
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'FINE'
            ]
        );
    }

}