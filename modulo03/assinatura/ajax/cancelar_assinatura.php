<?php

$pdo = new \PDO('mysql:host=localhost;dbname=assinaturas','root','root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from assinaturas where user = 2";
$user = $pdo->prepare($sql);
$user->execute();
$dadosUser = $user->fetch(PDO::FETCH_OBJ);

$urlAssinatura = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/cancel/'.$dadosUser->codigo.'?email=xandecar@hotmail.com&token=FF579CC8863549A783664FDC85657678';

$curl = curl_init($urlAssinatura);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$transaction_assinatura = trim(curl_exec($curl));
curl_close($curl);

$xml = simplexml_load_string($transaction_assinatura);
print_r($xml->error->code);

if($xml->error->code = '17022'){
    echo 'erro';
}

