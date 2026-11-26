/**
 * EcoPoint - Form Helpers: ViaCEP e Máscaras/Limitadores de Input
 * public/js/utils/form-helpers.js
 */

document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // 1. MÁSCARA E LIMITADOR DE TELEFONE
    // -------------------------------------------------------------
    const inputsTelefone = document.querySelectorAll('input[name="telefone"], input[name="telefone_contato"], #telefone, #telefone_contato');

    inputsTelefone.forEach(input => {
        input.setAttribute('maxlength', '15');

        const aplicarMascaraTelefone = () => {
            let valor = input.value.replace(/\D/g, ''); // apenas dígitos

            // Limita a no máximo 11 dígitos
            if (valor.length > 11) {
                valor = valor.slice(0, 11);
            }

            if (valor.length > 10) {
                // Formato celular: (11) 98765-4321
                input.value = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (valor.length > 6) {
                // Formato fixo intermediário: (11) 2345-6789
                input.value = valor.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (valor.length > 2) {
                input.value = valor.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
            } else if (valor.length > 0) {
                input.value = valor.replace(/^(\d*)$/, '($1');
            }
        };

        input.addEventListener('input', aplicarMascaraTelefone);
        // Formatar se já vier preenchido do banco/old
        if (input.value) {
            aplicarMascaraTelefone();
        }
    });

    // -------------------------------------------------------------
    // 2. MÁSCARA E LIMITADOR DE CNPJ
    // -------------------------------------------------------------
    const inputsCnpj = document.querySelectorAll('input[name="cnpj"], #cnpj');

    inputsCnpj.forEach(input => {
        input.setAttribute('maxlength', '18');

        const aplicarMascaraCnpj = () => {
            let valor = input.value.replace(/\D/g, ''); // apenas números

            if (valor.length > 14) {
                valor = valor.slice(0, 14);
            }

            if (valor.length > 12) {
                input.value = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2})$/, '$1.$2.$3/$4-$5');
            } else if (valor.length > 8) {
                input.value = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{1,4})$/, '$1.$2.$3/$4');
            } else if (valor.length > 5) {
                input.value = valor.replace(/^(\d{2})(\d{3})(\d{1,3})$/, '$1.$2.$3');
            } else if (valor.length > 2) {
                input.value = valor.replace(/^(\d{2})(\d{1,3})$/, '$1.$2');
            } else {
                input.value = valor;
            }
        };

        input.addEventListener('input', aplicarMascaraCnpj);
        if (input.value) {
            aplicarMascaraCnpj();
        }
    });

    // -------------------------------------------------------------
    // 3. LIMITADOR E FORMATADOR DE ESTADO (UF)
    // -------------------------------------------------------------
    const inputsEstado = document.querySelectorAll('input[name="estado"], #estado');

    inputsEstado.forEach(input => {
        input.setAttribute('maxlength', '2');
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^a-zA-Z]/g, '').toUpperCase().slice(0, 2);
        });
    });

    // -------------------------------------------------------------
    // 4. MÁSCARA DE CEP + AUTOCOMPLETE VIACEP
    // -------------------------------------------------------------
    const inputsCep = document.querySelectorAll('input[name="cep"], #cep');

    inputsCep.forEach(inputCep => {
        inputCep.setAttribute('maxlength', '9');
        inputCep.setAttribute('placeholder', '00000-000');

        // Cria ou localiza um elemento para exibir status/feedback do CEP
        let feedbackCep = inputCep.parentNode.querySelector('.cep-feedback');
        if (!feedbackCep) {
            feedbackCep = document.createElement('small');
            feedbackCep.className = 'cep-feedback';
            feedbackCep.style.display = 'block';
            feedbackCep.style.marginTop = '4px';
            feedbackCep.style.fontSize = '0.78rem';
            feedbackCep.style.fontWeight = '500';
            inputCep.parentNode.appendChild(feedbackCep);
        }

        const aplicarMascaraCep = () => {
            let valor = inputCep.value.replace(/\D/g, '');
            if (valor.length > 8) {
                valor = valor.slice(0, 8);
            }
            if (valor.length > 5) {
                inputCep.value = valor.replace(/^(\d{5})(\d{1,3})$/, '$1-$2');
            } else {
                inputCep.value = valor;
            }
        };

        inputCep.addEventListener('input', function () {
            aplicarMascaraCep();

            const cepNumerico = inputCep.value.replace(/\D/g, '');
            if (cepNumerico.length === 8) {
                consultarViaCep(cepNumerico, inputCep, feedbackCep);
            } else {
                feedbackCep.textContent = '';
                feedbackCep.style.color = '';
            }
        });

        inputCep.addEventListener('blur', function () {
            const cepNumerico = inputCep.value.replace(/\D/g, '');
            if (cepNumerico.length === 8) {
                consultarViaCep(cepNumerico, inputCep, feedbackCep);
            }
        });
    });

    /**
     * Faz requisição à API do ViaCEP e preenche os campos do formulário automaticamente.
     */
    function consultarViaCep(cep, inputCep, feedbackCep) {
        // Encontra o container/form pai para buscar os inputs relacionados
        const formContainer = inputCep.closest('form') || document;

        const inputEndereco = formContainer.querySelector('input[name="endereco"], #endereco');
        const inputBairro = formContainer.querySelector('input[name="bairro"], #bairro');
        const inputCidade = formContainer.querySelector('input[name="cidade"], #cidade');
        const inputEstado = formContainer.querySelector('input[name="estado"], #estado');
        const inputNumero = formContainer.querySelector('input[name="numero"], #numero');

        feedbackCep.textContent = 'Buscando CEP...';
        feedbackCep.style.color = '#3182ce';

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na requisição');
                }
                return response.json();
            })
            .then(dados => {
                if (dados.erro) {
                    feedbackCep.textContent = 'CEP não encontrado.';
                    feedbackCep.style.color = '#e53e3e';
                    return;
                }

                // Preenchimento automático dos dados retornados
                if (inputEndereco && dados.logradouro) {
                    inputEndereco.value = dados.logradouro;
                }
                if (inputBairro && dados.bairro) {
                    inputBairro.value = dados.bairro;
                }
                if (inputCidade && dados.localidade) {
                    inputCidade.value = dados.localidade;
                }
                if (inputEstado && dados.uf) {
                    inputEstado.value = dados.uf.toUpperCase();
                }

                feedbackCep.textContent = 'Endereço preenchido automaticamente!';
                feedbackCep.style.color = '#2f693a';

                // Foca diretamente no campo número para agilizar a digitação
                if (inputNumero) {
                    inputNumero.focus();
                }

                // Limpa mensagem de sucesso após 3.5 segundos
                setTimeout(() => {
                    if (feedbackCep.textContent === 'Endereço preenchido automaticamente!') {
                        feedbackCep.textContent = '';
                    }
                }, 3500);
            })
            .catch(() => {
                feedbackCep.textContent = 'Não foi possível consultar o CEP no momento.';
                feedbackCep.style.color = '#dd6b20';
            });
    }
});
