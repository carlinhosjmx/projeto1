<?php

namespace App\Classes\Paypal;

use App\Classes\Paypal\Paypal;

class SimulateWebHook extends Paypal{

    public function simulate($data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/notifications/simulate-event");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
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