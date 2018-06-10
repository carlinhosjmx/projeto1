<?php
ini_set('display_errors',1);
date_default_timezone_set('America/Sao_Paulo');

// pegar a data
$date = new \DateTime();
$date->setTimeZone(new \DateTimeZone('UTC'));
$date->add(new DateInterval('P1M'));
$dataFinal = $date->format('Y-m-d\T00:00:00\0-03:00');

$referencia = 'SITE'.md5(rand());

$arrayDadosPagseguro = [
    'email' => 'xandecar@hotmail.com',
    'token' =>'FF579CC8863549A783664FDC85657678',
    'senderName' => 'Marcio',
    'senderAreaCode' => '16',
    'senderPhone' => '981484937',
    'senderEmail' => 'contato@asolucoesweb.com.br',
    'senderAddressStreet' => 'Rua teste',
    'senderAddressNumber' => '64',
    'senderAddressComplement' => '1 andar',
    'senderAddressDistrict' => 'bairro',
    'senderAddressPostalCode' => '14811260',
    'senderAddressCity' => 'Araraquara',
    'senderAddressState' => strtoupper('sp'),
    'senderAddressCountry' =>'BRA',
    'preApprovalCharge' => 'auto',
    'preApprovalName' => 'Assinatura asolucoesweb',
    'preApprovalDetails' => 'Detalhes da assinatura',
    'preApprovalAmountPerPayment' => '59.00',
    'preApprovalPeriod' => 'Monthly',
    'preApprovalFinalDate' => $dataFinal,
    'preApprovalMaxTotalAmount' => '59.00',
    'reference' => $referencia,
    'redirectURL' => 'http://asolucoesweb.com.br',
    'reviewURL' => 'http://asolucoesweb.com.br'
];

    $urlHttp = http_build_query($arrayDadosPagseguro);
    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request';

    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_HTTPHEADER, Array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
    curl_setopt($curl,CURLOPT_POST,1);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_POSTFIELDS,$urlHttp);
    $transaction_curl = trim(curl_exec($curl));
    curl_close($curl);

   $xml = simplexml_load_string($transaction_curl);

   // cadastrar no banco de dados
    $pdo = new \PDO('mysql:host=localhost;dbname=assinaturas','root','root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "update assinaturas set referencia = ? where user =2";
    $cadastrar = $pdo->prepare($sql);
    $cadastrar->bindValue('1',$referencia);
    $cadastrar->execute();


     echo 'https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code='.$xml->code;
