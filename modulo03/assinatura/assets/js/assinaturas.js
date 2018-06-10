$(document).ready(function(){

    var container = $('.container');
    var btn_assinatura = container.find('#btn-assinar');
    var mensagem = container.find('.mensagem');

    btn_assinatura.on('click', function(event){
        event.preventDefault();

        $.ajax({
            url: 'ajax/assinaturas.php',
            type: 'GET',
            beforeSend:function(){
                mensagem.html('Verificando seus dados, aguarde...');
            },
            success: function(data){
                console.log(data);
            }
        });
    });
});