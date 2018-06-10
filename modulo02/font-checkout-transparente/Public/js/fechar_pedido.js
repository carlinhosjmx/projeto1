$(document).ready(function(){

     var container = $('.container');
     var form_fechar_pedido = container.find('#form-fechar-pedido');
     var btn_fechar_pedido = form_fechar_pedido.find('#btn-fechar-pedido');

     btn_fechar_pedido.on('click', function(event){

        event.preventDefault();

        var numero = form_fechar_pedido.find('#numero').val();
        var bandeira = form_fechar_pedido.find('#bandeira').val();
        var codigo = form_fechar_pedido.find('#digitos').val();
        var validade_mes = form_fechar_pedido.find('#validade-mes').val();
        var validade_ano = form_fechar_pedido.find('#validade-ano').val();
        var numeroParcelas = form_fechar_pedido.find('#parcelas').val();
        var hash = PagSeguroDirectPayment.getSenderHash();
        var statusFechamentoPedido = container.find('#status-fechar-pedido');


        // obter bandeira
        var bin = numero.substring(0,6);

        PagSeguroDirectPayment.getBrand({

            cardBin: bin,
            success: function(response){
              var cartao = response.brand.name;
              pegarToken(numero,cartao,codigo,validade_mes,validade_ano,hash);
            },
            error: function(response){
               var errosCartao = mostrarErros(response);
               statusFechamentoPedido.html(errosCartao);
            }
       });

        // pegar token

        function pegarToken(numero,cartao,codigo,validade_mes,validade_ano,hash){

              PagSeguroDirectPayment.createCardToken({
                  cardNumber: numero,
                  brand: cartao,
                  cvv: codigo,
                  expirationMonth: validade_mes,
                  expirationYear: validade_ano,
                  success: function(response){
                     var parcelas = (numeroParcelas == 1) ? 1 : numeroParcelas;
                     fecharPedido(450,parcelas,cartao,response.card.token,hash);
                  },
                  error: function(response){
                    var errosCartao = mostrarErros(response);
                    statusFechamentoPedido.html(errosCartao);
                  }
             });
        }

        // fechar o pedido
        function fecharPedido(totalPagamento,parcelas,cartao,token,hash){

            PagSeguroDirectPayment.getInstallments({
                  amount: totalPagamento,
                  maxInstallmentNoInterest: 4,
                  brand: cartao,
                  success: function(response){


                  $.ajax({
                       url: 'App/Ajax/fechar_pedido.php',
                       type: 'POST',
                       data: 'tokenCartao='+token+'&cartao='+cartao+'&parcelas='+parcelas+'&hash='+hash+'&valorParcela='+response.installments[cartao][parcelas-1]['installmentAmount'],
                       beforeSend: function(){
                           statusFechamentoPedido.html('<div style="margin-top:10px;" class="ui success message">Aguarde enqanto verificamos os dados fornecidos do seu cartão.</div>');
                       },
                       success: function(data){

                            if(data == 1){
                                statusFechamentoPedido.html('<div style="margin-top:10px;" class="ui success message">Seu pedido foi feito com sucesso, quando o pagseguro liberar o pagamento você será notificado e seu produto liberado.</div>');
                            }else if(data == 2){
                                statusFechamentoPedido.html('<div style="margin-top:10px;" class="ui success message">Seu pagamento está em análise, quando o pagseguro liberar o pagamento você será notificado e seu acesso liberado</div>');
                            }else if(data == 3){
                                statusFechamentoPedido.html('<div style="margin-top:10px;" class="ui success message">Seu pagamento foi aprovado, você acabou de receber um e-mail do pagseguro confirmando o pagamento e seu produto já foi liberado.</div>');
                            }
                       }
                    });
                  },error: function(response){
                      var errosCartao = mostrarErros(response);
                      statusFechamentoPedido.html(errosCartao);
                  }
            });
        }
    });
});
