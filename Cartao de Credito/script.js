document.addEventListener("DOMContentLoaded", function () {
    const cardNumberInputs = document.querySelectorAll("#card-number");
const cardHolderInput = document.getElementById("card-holder");
const cardExpirationMonthSelect = document.getElementById("card-expiration-month");
const cardExpirationYearSelect = document.getElementById("card-expiration-year");
const cardCCVInput = document.getElementById("card-ccv");


    // Adiciona event listeners para cada input do número do cartão
    cardNumberInputs.forEach(function (input, index) {
        input.addEventListener("input", function () {
            formatCardNumber(input, index);
            updateCardNumber();
        });
    });

    // Adiciona event listener para o nome do titular do cartão
    cardHolderInput.addEventListener("input", function () {
        updateCardHolder();
    });

    // Adiciona event listener para o mês e ano de expiração do cartão
    cardExpirationMonthSelect.addEventListener("change", updateCardExpirationDate);
    cardExpirationYearSelect.addEventListener("change", updateCardExpirationDate);

    // Adiciona event listener para o CCV do cartão
    cardCCVInput.addEventListener("input", function () {
        updateCardCCV();
    });

    // Função para formatar o número do cartão
    function formatCardNumber(input, currentIndex) {
        let cardNumber = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        cardNumber = cardNumber.slice(0, 19); // Limita o número do cartão a 19 caracteres

        // Insere espaços a cada 4 dígitos
        cardNumber = cardNumber.replace(/(.{4})/g, '$1 ');

        // Atualiza o valor do campo com o número formatado
        input.value = cardNumber;

        // Se o comprimento do valor atual for igual a 4, passa o foco para o próximo campo
        if (cardNumber.length === 5 && currentIndex < cardNumberInputs.length - 1) {
            cardNumberInputs[currentIndex + 1].focus();
        }
    }

    // Função para atualizar o número do cartão no cartão visual
    function updateCardNumber() {
        let cardNumber = "";
        cardNumberInputs.forEach(function (input) {
            cardNumber += input.value.padEnd(19, "•") + " ";
        });
        document.querySelector(".number").textContent = cardNumber.trim();
    }

    // Função para atualizar o nome do titular do cartão
    function updateCardHolder() {
        const cardHolder = cardHolderInput.value || "CARD HOLDER";
        document.querySelector(".card-holder div").textContent = cardHolder.toUpperCase();
    }

    // Função para atualizar a data de expiração do cartão
    function updateCardExpirationDate() {
        const expirationMonth = cardExpirationMonthSelect.value.padStart(2, '0') || "MM";
        const expirationYear = cardExpirationYearSelect.value.slice(-2) || "YY";
        document.querySelector(".card-expiration-date div").textContent = `${expirationMonth}/${expirationYear}`;
    }

    // Função para atualizar o CCV do cartão
    function updateCardCCV() {
        const ccv = cardCCVInput.value || "CVV";
        document.querySelector(".ccv div").textContent = ccv;
    }
});
