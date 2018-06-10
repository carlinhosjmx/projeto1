$(document).ready(function(){
    
       var container = $('.container');
       var form_fechar_pedido = container.find('#form-fechar-pedido');
       var selectBandeiras = form_fechar_pedido.find('#bandeira') ;
       var divBandeiras = container.find('.bancos');

       $.ajax({
         
            url: '/App/Ajax/sessao_pagseguro.php',
            dataType: 'json',
            success: function(data){
                var idSessao = data.id;
                PagSeguroDirectPayment.setSessionId(idSessao);
                PagSeguroDirectPayment.getPaymentMethods({
                        
                    success: function(response){
                       var bancos = '';
                       var listaBandeiras = '';
                       $.each(response.paymentMethods.CREDIT_CARD.options, function(key,value){
                            listaBandeiras+= '<option value='+value.name+'>'+value.name+'</option>';
                            bancos+= '<div class="two wide column">'+value.name+'<br /><img src=https://stc.pagseguro.uol.com.br/'+value.images.SMALL.path+' /></div>';   
                               
                      });
                       divBandeiras.html(bancos);
                       selectBandeiras.html(listaBandeiras);
                    }     
                });
            }
               
      });
        
 });
