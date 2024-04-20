   var currentUser = JSON.parse(localStorage.getItem('currentUser'));

   var products = document.querySelectorAll('.product');
   
   products.forEach(function(product) {
       product.addEventListener('click', function() {
           var userType = currentUser.userType;
   
           var operation = product.getAttribute('data-OPERAÇÃO');
   
           if ((userType === 'comprador' && operation === 'Comprar') ||
               (userType === 'vendedor' && operation === 'Vender')) {
               var productID = product.getAttribute('data-ID');
               var productTitle = product.getAttribute('data-TITULO');
               var productSide = product.getAttribute('data-LADO');
               var productSize = product.getAttribute('data-TAMANHO');
               var productCondition = product.getAttribute('data-ESTADO');
               var productPrice = product.getAttribute('data-PREÇO');
               var productBrand = product.getAttribute('data-MARCA');
   
               var productInfo = {
                   ID: productID,
                   TITULO: productTitle,
                   LADO: productSide,
                   TAMANHO: productSize,
                   ESTADO: productCondition,
                   PREÇO: productPrice,
                   MARCA: productBrand,
                   OPERAÇÃO: operation
               };
   
               localStorage.setItem(currentUser.email + '_product_' + productID, JSON.stringify(productInfo));
           } else {
              
               alert('Você não tem permissão para realizar esta operação.');
           }
       });
   });
   