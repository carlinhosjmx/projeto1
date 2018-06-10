$(document).ready(function(){

    var container = $('.container');
    var btn_pagar_boleto = container.find('#btn-pagar-boleto');
    var mensagem_boleto = container.find('#mensagem-boleto');

    btn_pagar_boleto.on('click', function(event){
        event.preventDefault();

        var hash = PagSeguroDirectPayment.getSenderHash();

        $.ajax({
            url: 'App/Ajax/boleto.php',
            type: 'POST',
            data: 'hash='+hash,
            beforeSend: function(){
                mensagem_boleto.html('<div style="margin-top:10px;" class="ui success message">Aguarde enquanto estamos gerando o boleto.</div>');
            },
            success: function(data){
                window.location.href = data;
            }
        });
    });
});