$(document).ready(function(){

    var container = $('.container');
    var message = container.find('#message');
    var btn_submit_paypal = container.find("#btn-submit-paypal");

    btn_submit_paypal.on('click',function(event){
        event.preventDefault();
        $.ajax({
            url:'/ajax/paypal_environment.php',
            type:'post',
            dataType:'json',
            beforeSend:function(){
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Aguarde enquanto estamos redirecionando você para o payapal.</div>");
            },
            success: function(retorno){
                console.log(retorno);
                if(retorno == 'notLoggedIn'){
                    window.location.href = '/pages/notLoggedIn.php';
                }

                if(retorno.state == 'created'){
                    window.location.href = retorno.link;
                }
            }
        });
    });
});