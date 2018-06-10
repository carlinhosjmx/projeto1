<?php

require '../../config.php';
use App\Classes\Paypal\Payment;
use App\Models\Site\Sale;

$payerId = filter_input(INPUT_GET,'PayerID',FILTER_SANITIZE_STRING);
$paymentId = filter_input(INPUT_GET,'paymentId',FILTER_SANITIZE_STRING);

if(isset($payerId)){

    $payer = [
        'payerId' => [
            'payer_id' => $payerId
        ],
        'paymentId' => $paymentId
    ];

    $payment = new Payment;
    $returnPayment = $payment->executeApprovedPayment($payer);
    // dump($returnPayment);
    if($returnPayment->state == 'approved'){
        $sale = new Sale;
        $sale->update($returnPayment->id,1);
        header('location:/');
    }
}