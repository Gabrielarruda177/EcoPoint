document.addEventListener('DOMContentLoaded', function () {
    const inputBusca = document.getElementById('search-ong');
    const botaoLimpar = document.querySelector('.limpar-ong');
    const cardsOngs = document.querySelectorAll('.card-ong');
    const avisoNenhuma = document.getElementById('nenhuma-ong');

    function normalizarTexto(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
    }

    function filtrarOngs() {
        const termo = normalizarTexto(inputBusca.value);
        let contadorVisiveis = 0;

        cardsOngs.forEach(card => {
            const nomeOng = normalizarTexto(card.getAttribute('data-nome'));

            if (nomeOng.includes(termo)) {
                card.style.display = 'flex';
                contadorVisiveis++;
            } else {
                card.style.display = 'none';
            }
        });

        if (avisoNenhuma) {
            if (contadorVisiveis === 0) {
                avisoNenhuma.style.display = 'block';
            } else {
                avisoNenhuma.style.display = 'none';
            }
        }
    }

    if (inputBusca) {
        inputBusca.addEventListener('input', filtrarOngs);
    }

    if (botaoLimpar && inputBusca) {
        botaoLimpar.addEventListener('click', function () {
            inputBusca.value = '';
            filtrarOngs();
            inputBusca.focus();
        });
    }
});