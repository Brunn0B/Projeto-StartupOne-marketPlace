document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.product-form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const productName = document.getElementById('productName').value;
        const productDescription = document.getElementById('productDescription').value;
        const productPrice = document.getElementById('productPrice').value;
        const productImage = document.getElementById('productImage').files[0];

        const formattedPrice = parseFloat(productPrice).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        const productCard = document.createElement('div');
        productCard.classList.add('product');

        const productImageElement = document.createElement('img');
        productImageElement.alt = productName;

        const productNameElement = document.createElement('h3');
        productNameElement.textContent = productName;

        const productDescriptionElement = document.createElement('p');
        productDescriptionElement.textContent = productDescription;

        const productPriceElement = document.createElement('p');
        productPriceElement.textContent = `Preço: ${formattedPrice}`;

        productCard.appendChild(productImageElement);
        productCard.appendChild(productNameElement);
        productCard.appendChild(productDescriptionElement);
        productCard.appendChild(productPriceElement);

        const productPreview = document.querySelector('.productPreview');
        productPreview.appendChild(productCard);

        form.reset();

        const reader = new FileReader();
        reader.onload = function(e) {
            productImageElement.src = e.target.result;
            addDetailsClickListener(productName, productDescription, productPrice, e.target.result);
        };
        reader.readAsDataURL(productImage);
    });


    function addDetailsClickListener(name, description, price, imageBase64) {
        const productCard = document.querySelector('.product');
        const detailsButton = productCard.querySelector('.btn-details');

        if (!detailsButton) {
            const detailsButton = document.createElement('button');
            detailsButton.classList.add('btn-details');
            detailsButton.textContent = 'Detalhes';

            detailsButton.addEventListener('click', function() {
                showPopup(name, description, price, imageBase64);
            });

            productCard.appendChild(detailsButton);
        }
    }

    function showPopup(name, description, price, imageBase64) {
        const popup = document.createElement('div');
        popup.classList.add('popup');
    
        const content = document.createElement('div');
        content.classList.add('popup-content');
    
        const closeButton = document.createElement('span');
        closeButton.classList.add('close-popup');
        closeButton.textContent = 'Fechar';
        closeButton.addEventListener('click', function() {
            popup.remove();
        });
    
        const popupImage = document.createElement('img');
        popupImage.src = imageBase64;
        popupImage.alt = name;
    
        const productName = document.createElement('h2');
        productName.textContent = name;
    
        const productDescription = document.createElement('p2');
        productDescription.textContent = description;
    
        const formattedPrice = parseFloat(price).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        const productPrice = document.createElement('p2');
        productPrice.textContent = `Preço: ${formattedPrice}`;
    
        // Recuperar os dados do usuário do localStorage
        const currentUserData = localStorage.getItem('currentUser');
        if (currentUserData) {
            const currentUserInfo = JSON.parse(currentUserData);
            const userType = currentUserInfo.userType;
            const userName = currentUserInfo.name; 
    
            const userInfo = document.createElement('div');
            userInfo.innerHTML = `
                <h3>Informações do ${userType === 'comprador' ? 'Comprador' : 'Vendedor'}:</h3>
                
            `;
            content.appendChild(userInfo);
            const userEmail = currentUserInfo.email;
            const userAddressData = localStorage.getItem(userEmail + '_profile');
            if (userAddressData) {
                const userAddress = JSON.parse(userAddressData).address;
                if (userAddress) {
                    const addressInfo = document.createElement('div');
                    addressInfo.innerHTML = `
                        <p>Nome: ${userName}</p>
                        <p>CEP: ${userAddress.cep}</p>
                        <p>Estado: ${userAddress.state}</p>
                        <p>Cidade: ${userAddress.city}</p>
                        <p>Bairro: ${userAddress.neighborhood}</p>
                        <p>Endereço: ${userAddress.street}, ${userAddress.number}</p>
                    `;
                    content.appendChild(addressInfo);
                }
            } else {
                const addressInfo = document.createElement('p');
                addressInfo.textContent = 'Endereço do vendedor não disponível';
                content.appendChild(addressInfo);
            }
        }

    
        content.appendChild(closeButton);
        content.appendChild(popupImage);
        content.appendChild(productName);
        content.appendChild(productDescription);
        content.appendChild(productPrice);
        popup.appendChild(content);

        document.body.appendChild(popup);
    }
});
