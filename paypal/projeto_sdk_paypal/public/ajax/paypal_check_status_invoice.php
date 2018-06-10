<?php

require '../../config.php';

use PayPal\Api\Invoice;
use App\Models\Site\Invoice as InvoiceModel;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_NUMBER_INT);

    $invoiceModel = new InvoiceModel();
    $dadosInvoice = $invoiceModel->find('id',$id);

    if(!$dadosInvoice){
        echo json_encode('faturaNaoEncontrada');
        die();
    }

    $statusInvoice = Invoice::get($dadosInvoice->invoice_id,$api->api);
    $invoiceModel->update($id, $statusInvoice->status);
    echo json_encode(statusInvoice($statusInvoice->status));

}