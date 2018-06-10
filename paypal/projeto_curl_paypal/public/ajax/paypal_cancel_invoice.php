<?php

require '../../config.php';

use App\Models\Site\Invoice as InvoiceModel;
use App\Classes\Paypal\Invoice;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];
    $invoiceModel = new InvoiceModel;
    $idInvoice = $invoiceModel->find('id',$id);

    $data = [
        'subject' => 'Cancelar Fatura',
        'note' => 'Cancelando a fatura',
        'send_to_merchant' => true,
        'send_to_payer' => true
    ];

    $invoice = new Invoice;
    $invoice->cancel($idInvoice->invoice_id,$data);
    $getInvoice = $invoice->getInvoice($idInvoice->invoice_id);

    if($getInvoice->status == 'CANCELLED'){
        $invoiceModel->update($id,$getInvoice->status);
        echo json_encode('cancelled');
    }else{
        echo json_encode('error');
    }
}