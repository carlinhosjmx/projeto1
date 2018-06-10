$(document).ready(function(){
   
    var container = $('.container');
    var form_fechar_pedido = container.find('#form-fechar-pedido');
    var bandeira = form_fechar_pedido.find('#bandeira');
    var parcelas = form_fechar_pedido.find('#parcelas');
    var parcelasCartao = container.find('#parcelas-cartao');
    var totalPagamento = 450;

    bandeira.on('change',function(){
            
      var cartao = $(this).val().toLowerCase();       

      parcelasCartao.html('Carregando parcelas do cartão '+cartao);  
       
      PagSeguroDirectPayment.getInstallments({
        
        amount: totalPagamento,
        maxInstallmentNoInterest: 4,
        brand: cartao,
        success: function(response){
       
          numeral.language('pt-br');
          var numeroParcelas = '';
          var juros = '';
          var numeroParcelasSelect = '';

          var installment = response.installments[cartao];
                
           $.each(installment, function(key,value){
               juros = (value.interestFree == true) ? 'sem juros' : 'com juros';
               numeroParcelas+= '<div style="margin-bottom:10px;">'+value.quantity+' parcelas '+numeral(value.installmentAmount).format('$ 0,0.00')+'</div>';
               numeroParcelasSelect+= '<option value='+value.quantity+'>'+value.quantity+'x de '+numeral(value.installmentAmount).format('$ 0,0.00')+'</option>';
          });

           parcelasCartao.html(numeroParcelas);
           parcelas.html(numeroParcelasSelect);
        
        },
        error: function(response){

        }
              
      });  

   });
        
});
