$(document).ready(function(){

    var container = $('.container');
    var btn_pagar_debito= container.find('#btn-pagar-debito');
    var mensagem_debito = container.find('#mensagem-debito');

    btn_pagar_debito.on('click', function(event){
        event.preventDefault();

        var hash = PagSeguroDirectPayment.getSenderHash();

        $.ajax({
            url: 'App/Ajax/debito.php',
            type: 'POST',
            data: 'hash='+hash,
            beforeSend: function(){
                mensagem_debito.html('<div style="margin-top:10px;" class="ui success message">Aguarde enquanto estamos verificando seus dados e iremos lhe enviar para o pagamento em débito automático.</div>');
            },
            success: function(data){
                console.log(data);
                // window.location.href = data;
            }
        });
    });
});