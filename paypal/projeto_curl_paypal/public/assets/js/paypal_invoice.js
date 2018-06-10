$(document).ready(function(){

    var container = $('.container');
    var message = container.find('#message');
    var email = container.find('#email');
    var valor = container.find('#valor');
    var btn_enviar_invoice = container.find('#btn-submit-invoice');
    var btn_cancelar_invoice = container.find('.btn-cancel-invoice');

    btn_enviar_invoice.on('click',function(event){
        event.preventDefault();
        $.ajax({
            url:'/ajax/paypal_invoice.php',
            type: 'post',
            data:'email='+email.val()+'&valor='+valor.val(),
            dataType:'json',
            beforeSend: function(){
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Aguarde enquanto estamos enviando a fatura</div>");
            },
            success: function(retorno){
                console.log(retorno);
                if(retorno =='notLogged'){
                    window.location.href = '/pages/notLoggedIn.php';
                }

                if(retorno == 'sent'){
                    message.html("<div class='alert alert-success'><i class='fa fa-check-circle fa-3x fa-fw'></i> Cobrança enviada com sucesso para "+email.val()+" </div>");
                    setTimeout(function(){
                        location.reload();
                    },3000);
                }
            }
        });
    });

    btn_cancelar_invoice.on('click', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url:'/ajax/paypal_cancel_invoice.php',
            type:'post',
            data:'id='+id,
            dataType:'json',
            beforeSend: function(){
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Aguarde enquanto estamos cancelando a fatura</div>");
            },
            success: function(retorno){
                console.log(retorno);
                if(retorno == 'cancelled'){
                    message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Essa fatura foi cancelada com sucesso !!</div>");
                    setTimeout(function(){
                        location.reload();
                    },3000);
                }

                if(retorno == 'error'){
                    message.html("<div class='alert alert-danger'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Ocorreu um erro ao cancelar essa fatura, tente novamente em alguns segundos</div>");
                    setTimeout(function(){
                        location.reload();
                    },3000);
                }
            }
        });
    });

});