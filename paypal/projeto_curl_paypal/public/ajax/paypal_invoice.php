<?php

require '../../config.php';

use App\Classes\Login;
use App\Classes\Paypal\Invoice;
use App\Models\Site\{User,Invoice as InvoiceModel};

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = new Login();
    if(!$login->isLoggedIn()){
        echo json_encode('notLogged');
        die();
    }

    $email = $_POST['email'];
    $valor = $_POST['valor'];

    $user = new User;
    $userEncontrado = $user->find('email',$email);

    if(!$userEncontrado){
        echo json_encode('notFoundUser');
        die();
    }

    $data = [
        "merchant_info" =>[
            'email' => 'contato@asolucoesweb.com.br',
            'first_name' => 'Alexandre',
            'last_name' => 'Cardoso',
            'business_name' => 'Asolucoesweb',
            'phone' => [
                'country_code' => '055',
                'national_number' => '16981484937'
            ],
            'address' => [
                'line1' => 'rua joao goulart',
                'city' => 'araraquara',
                'state' => 'sp',
                'postal_code' => '14811260',
                'country_code' => 'BR'
            ]
        ],
        'billing_info' => array([
            'email' => $email
        ]),
        'items' => array([
            'name' => 'Fatura asolucoesweb',
            'quantity' => '1',
            'unit_price' => [
                'currency' => 'BRL',
                'value' => $valor
            ]
        ]),
        'note' => 'Cobrança de curso php sem medo',
        'payment_term' => [
            'term_type' => 'NET_45'
        ],
        'shipping_info' => [
            'first_name' => 'Marcio',
            'last_name' => 'Santos',
            'business_name' => 'Empresa Teste',
            'phone' => [
                'country_code' => '055',
                'national_number' => '16992467199'
            ],
            'address' => [
                'line1' => 'rua empresa teste',
                'city' => 'Sao Paulo',
                'state' => 'sp',
                'postal_code' => '14811260',
                'country_code' => 'BR'
            ]
        ]
    ];

    $invoice = new Invoice();
    $invoiceReturned = $invoice->create($data);
    $invoice->send($invoiceReturned->id);

    $getInvoice = $invoice->getInvoice($invoiceReturned->id);
    // var_dump($getInvoice);

    $invoiceModel= new InvoiceModel;
    $invoiceModel->create($userEncontrado->id,$invoiceReturned->id,$getInvoice->status,$getInvoice->template_id,$valor);

    if($getInvoice->status == 'SENT'){
        echo json_encode('sent');
        die();
    }

}