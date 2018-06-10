<?php

$emailPagSeguro = 'xandecar@hotmail.com';
$tokenPagseguro = 'FF579CC8863549A783664FDC85657678';
$notificationCode = '1539DF3CE397E3971F2994FABFBE51613CF2';

$urlAssinatura = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/notifications/'.$notificationCode.'?email=' . $emailPagSeguro . '&token=' . $tokenPagseguro;

$curl = curl_init($urlAssinatura);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$transaction_assinatura = trim(curl_exec($curl));
curl_close($curl);

if($transaction_assinatura == 'Not Found'){

    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/'.$notificationCode.'?email=' . $emailPagSeguro . '&token=' . $tokenPagseguro;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction_venda = trim(curl_exec($curl));
    curl_close($curl);

    $transaction = simplexml_load_string(utf8_decode($transaction_venda));
    $status = $transaction->status;
    $tipo = $transaction->type;

    if($status == '3'){
        if($tipo == '11'){

        }
    }

}else{

    $transaction = simplexml_load_string(utf8_decode($transaction_assinatura));
    $status = $transaction->status;

    echo '<pre>';
    print_r($transaction);
    echo '</pre>';

    if($status == 'ACTIVE'){

        $codigo = $transaction->code;
        echo $codigo;
        $status = 1;

    }else if($status == 'PENDING'){

    }else if($status == 'CANCELLED'){

    }else if($status == 'CANCELLED_BY_RECEIVER'){

    }else if($status == 'CANCELLED_BY_SENDER'){

    }

}