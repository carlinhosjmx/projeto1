$(document).ready(function(){

    var container = $('.container');
    var form_credit_card = container.find('#form-credit-card');
    var btn_submit_credit_card = form_credit_card.find('#btn-submit-credit-card');
    var message = container.find('#message');

    btn_submit_credit_card.on('click',function(event){
        event.preventDefault();
        $.ajax({
            url:'/ajax/paypal_credit_card.php',
            type:'post',
            dataType:'json',
            data:form_credit_card.serialize(),
            beforeSend: function(){
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>Aguarde enquanto verificamos seus dados do cartão.</div>");
            },
            success: function(retorno){
                console.log(retorno);

                if(retorno == 'notLoggenIn'){
                    window.location.href = '/pages/notLoggedIn.php';
                }

                if(retorno == 'approved'){
                    message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>Seu pagamento foi aprovado, estamos te redirecionando para a página restrita</div>");
                    setTimeout(function(){
                        window.location.href = '/pages/restrict.php';
                    },3000);
                }

                if(retorno == 'created'){
                    message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>Seu pagamento ainda não foi aprovado, quando aprovar lhe mandaremos um email com todos os dados</div>");
                }

                if(retorno == 'failed'){
                    message.html("<div class='alert alert-danger'><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>Seu pagamento foi rejeitado.</div>");
                        setTimeout(function(){
                            window.location.href = '/pages/failed.php';
                        },3000);
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
    });

});