<a href="/" class="btn btn-success btn-xs" style="marg
10px;">
<i class="fa fa-paypal"></i>
    Voltar para o início
</a>
<?php
    $invoiceModel = new App\Models\Site\Invoice;
    $invoices =$invoiceModel->invoices();
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Status</th>
            <th>Price</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php  if(empty($invoices)): ?>
        <tr>
            <td>Nenhuma fatura enviada</td>
        </tr>
    <?php endif; ?>
    <?php foreach($invoices as $invoice): ?>
        <tr>
            <td><?php echo $invoice->invoiceId; ?></td>
            <td><?php echo $invoice->name; ?></td>
            <td><?php echo $invoice->status; ?></td>
            <td><?php echo money_format('%n',$invoice->price); ?></td>
            <td>
                <a href="#" class="btn btn-default btn-xs btn-check-status-invoice" data-id="<?php echo $invoice->invoiceId; ?>">Verificar status</a>
            </td>
            <td>
                <a href="#" class="btn btn-danger btn-xs btn-cancel-invoice" data-id="<?php echo $invoice->invoiceId; ?>">Cancelar fatura</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>
    <i class="fa fa-paypal"></i>
    Enviar Fatura com paypal
</h2>

<div class="col-xs-6">
    <input type="text" name="email" id="email" class="form-control" placeholder="Email para enviar a cobrança">
</div>

<div class="col-xs-6">
    <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor da cobrança">
</div>

<br>
<br>

<div class="col-xs-2">
   <button id="btn-submit-invoice" class="btn btn-default">Enviar cobrança</button>
</div>