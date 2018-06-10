<?php

namespace App\Classes\Paypal;

class Token{

    private $clientId = "AUlysqZ8Y9sx2cV5VOzpKaOXcf28rriWm8lWrz_sa2xpHvWRfPwnqGAWtBY6hvGJKOMGkwMOGwgLbTQS";
    private $secret = "EEcWFNkHwxJIc85tM13JKYotrS9o-4nHkqLPOdx726uLinbgApC2IEa2mzVjngZ28MlSMDLx_exu95rD";

    public function token(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->clientId.":".$this->secret);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($result);
        return $json->access_token;
    }

}