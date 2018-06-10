<?php

namespace App\Classes\Paypal;
use App\Classes\Paypal\Paypal;

class Payment extends Paypal{

    public function payment($data){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json",
          "Authorization: Bearer {$this->token}"
          )
        );
        $retorno_transaction = curl_exec($curl);
        curl_close($curl);
        return json_decode($retorno_transaction);
    }

    public function executeApprovedPayment(Array $payer){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment/{$payer['paymentId']}/execute");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($payer['payerId']));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json",
          "Authorization: Bearer {$this->token}"
          )
        );
        $retorno_transaction = curl_exec($curl);
        curl_close($curl);
        return json_decode($retorno_transaction);
    }

    public function checkPayment($paymentId){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment/{$paymentId}");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json",
          "Authorization: Bearer {$this->token}"
          )
        );
        $retorno_transaction = curl_exec($curl);
        curl_close($curl);
        return json_decode($retorno_transaction);
    }
}