@extends('layouts.app')

@section('titulo', 'Fale Conosco')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/contato.css') }}?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endsection

@section('conteudo')
    <section class="diretorio-section">
        <a href="{{ route('publico.home') }}">Início</a>
        <span>
            <i class="fa-solid fa-chevron-right"></i>
            Fale Conosco
        </span>
    </section>

    <div class="contato-container">
        <div class="contato-header">
            <span class="contato-tag">
                <i class="fa-solid fa-headset"></i> Atendimento e Suporte
            </span>
            <h1 class="contato-titulo">Fale com a Equipe EcoPoint</h1>
            <p class="contato-subtitulo">
                Tem alguma dúvida sobre doação de livros, sugestões de novos pontos de coleta, quer firmar parcerias com sua ONG ou precisa de ajuda técnica? Envie uma mensagem e retornaremos o mais rápido possível!
            </p>
        </div>

        <div class="contato-grid">
            <!-- Coluna de Informações / Painel Lateral -->
            <aside class="contato-info-panel">
                <div class="info-card-header">
                    <h3>Canais de Contato</h3>
                    <p>Estamos prontos para ouvir sua comunidade.</p>
                </div>

                <div class="info-items-list">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <span class="info-label">E-mail de Suporte</span>
                            <a href="mailto:ecopointssuporte@gmail.com" class="info-link">ecopointssuporte@gmail.com</a>
                            <p class="info-desc">Canal direto para atendimento ao usuário e ONGs.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="info-text">
                            <span class="info-label">Horário de Atendimento</span>
                            <strong class="info-value">Segunda a Sexta-feira</strong>
                            <p class="info-desc">Das 08h às 18h (Horário de Brasília).</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div class="info-text">
                            <span class="info-label">Tempo Médio de Resposta</span>
                            <strong class="info-value">Até 24h a 48h úteis</strong>
                            <p class="info-desc">Analisamos sua demanda com atenção e dedicação.</p>
                        </div>
                    </div>
                </div>

                <div class="info-banner-ong">
                    <div class="banner-icon">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <div class="banner-content">
                        <h4>É representante de uma ONG?</h4>
                        <p>Descubra como cadastrar sua instituição para receber livros e apostilas arrecadados.</p>
                        <a href="{{ route('publico.ongs.index') }}" class="btn-banner-ong">
                            Ver ONGs Cadastradas <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Coluna do Formulário -->
            <section class="contato-form-section">
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>Envie sua Mensagem</h2>
                        <p>Preencha os campos abaixo e nosso suporte responderá diretamente no seu e-mail.</p>
                    </div>

                    <form action="{{ route('publico.contato.enviar') }}" method="POST" class="form-contato" id="formContato">
                        @csrf

                        <!-- Campo Nome -->
                        <div class="form-group @error('nome') has-error @enderror">
                            <label for="nome">
                                <span>Nome Completo</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    name="nome" 
                                    id="nome" 
                                    value="{{ old('nome') }}" 
                                    placeholder="Digite seu nome completo"
                                    required 
                                    minlength="2"
                                    maxlength="120"
                                    autocomplete="name"
                                >
                            </div>
                            @error('nome')
                                <span class="input-feedback error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo E-mail -->
                        <div class="form-group @error('email') has-error @enderror">
                            <label for="email">
                                <span>Seu E-mail para Contato</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-envelope input-icon"></i>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="exemplo@gmail.com"
                                    required 
                                    maxlength="120"
                                    autocomplete="email"
                                >
                            </div>
                            @error('email')
                                <span class="input-feedback error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Assunto -->
                        <div class="form-group @error('assunto') has-error @enderror">
                            <label for="assunto">
                                <span>Assunto da Mensagem</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-tag input-icon"></i>
                                <input 
                                    type="text" 
                                    name="assunto" 
                                    id="assunto" 
                                    list="sugestoes-assuntos"
                                    value="{{ old('assunto') }}" 
                                    placeholder="Ex: Dúvida sobre doações, sugestão de ponto..."
                                    required 
                                    minlength="3"
                                    maxlength="150"
                                >
                                <datalist id="sugestoes-assuntos">
                                    <option value="Dúvida sobre ponto de coleta">
                                    <option value="Quero sugerir um novo ponto de coleta">
                                    <option value="Interesse em cadastrar uma ONG parceira">
                                    <option value="Dúvida sobre tipos de livros aceitos">
                                    <option value="Relato de erro ou instabilidade na plataforma">
                                    <option value="Elogio ou sugestão de melhoria">
                                    <option value="Outros assuntos">
                                </datalist>
                            </div>
                            @error('assunto')
                                <span class="input-feedback error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo Mensagem -->
                        <div class="form-group @error('mensagem') has-error @enderror">
                            <label for="mensagem">
                                <span>Mensagem</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="textarea-wrapper">
                                <textarea 
                                    name="mensagem" 
                                    id="mensagem" 
                                    rows="6" 
                                    placeholder="Escreva sua mensagem com o máximo de detalhes possível para que possamos ajudá-lo(a)..."
                                    required
                                    minlength="10"
                                    maxlength="3000"
                                >{{ old('mensagem') }}</textarea>
                            </div>
                            <div class="textarea-footer">
                                @error('mensagem')
                                    <span class="input-feedback error">{{ $message }}</span>
                                @else
                                    <span class="textarea-hint">Mínimo de 10 caracteres.</span>
                                @enderror
                                <span id="contadorCaracteres" class="contador-caracteres">0 / 3000</span>
                            </div>
                        </div>

                        <!-- Botão de Envio -->
                        <div class="form-actions">
                            <button type="submit" class="btn-submit-contato" id="btnSubmitContato">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Enviar Mensagem</span>
                            </button>
                        </div>

                        <p class="privacidade-nota">
                            <i class="fa-solid fa-shield-halved"></i>
                            Garantimos a segurança de suas informações. Os dados fornecidos serão usados unicamente pela nossa equipe de suporte para responder à sua solicitação.
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('mensagem');
            const contador = document.getElementById('contadorCaracteres');
            const form = document.getElementById('formContato');
            const btnSubmit = document.getElementById('btnSubmitContato');

            if (textarea && contador) {
                const atualizarContador = () => {
                    const total = textarea.value.length;
                    contador.textContent = `${total} / 3000`;
                };

                textarea.addEventListener('input', atualizarContador);
                atualizarContador();
            }

            if (form && btnSubmit) {
                form.addEventListener('submit', function () {
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Enviando mensagem...</span>';
                });
            }
        });
    </script>
@endsection
