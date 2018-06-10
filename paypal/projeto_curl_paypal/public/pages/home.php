<a href="?p=paypal" class="btn btn-primary btn-xs" style="margin-top:10px;">
    <i class="fa fa-paypal"></i> Pagar com Paypal
</a>

<a href="?p=invoice" class="btn btn-default btn-xs" style="margin-top:10px;">
    <i class="fa fa-paypal"></i> Enviar uma fatura
</a>

<h2><i class="fa fa-cc-paypal" aria-hidden="true"></i>
    Paypal com cartão de crédito</h2>
<form method="post" action="" id="form-credit-card">
    <label>Name</label>
    <input type="text" name="name" placeholder="name" class="form-control" value="Alexandre"> <br>
    <label>Last Name</label>
    <input type="text" name="last_name" placeholder="last_name" class="form-control" value="Cardoso"> <br>
    <label>Type</label>
    <input type="text" name="type_card" placeholder="type_card" class="form-control" value="visa"> <br>
    <label>Number Card</label>
    <input type="text" name="number_card" placeholder="number_card" class="form-control" value="4002350784536533"> <br>
    <label>Expire Year</label>
    <input type="text" name="expire_year" placeholder="expire_year" class="form-control" value="2021"> <br>
    <label>Expire Month</label>
    <input type="text" name="expire_month" placeholder="expire_month" class="form-control" value="05"> <br>
    <label>Cvv</label>
    <input type="text" name="cvv" placeholder="cvv" class="form-control" value="123"> <br>
    <button class="btn btn-default" id="btn-submit-credit-card" style="margin-bottom: 10px;">Pagar</button>
</form>