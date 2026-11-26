@extends('layouts.admin')

@section('titulo', 'Cadastrar ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/ongs-create.css') }}?v=1.2">
@endsection

@section('conteudo')
<div class="create-ong-container">
    <a href="{{ route('admin.ongs.index') }}" class="back-link">
        &larr; Voltar para lista de ONGs
    </a>

    <div class="create-ong-card">
        <div class="create-ong-header">
            <span class="badge badge-admin">Perfil: Administrador</span>
            <h1 class="create-ong-title">Cadastrar Nova ONG</h1>
            <p class="create-ong-subtitle">
                Informe os dados da instituição e defina as credenciais de acesso para a organização parceira.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert-errors">
                <div class="alert-errors-title">Corrija os erros encontrados:</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.ongs.store') }}" method="POST">
            @csrf

            <div class="form-section">
                <h2 class="form-section-title">Dados da Instituição</h2>
                <p class="form-section-subtitle">Informações gerais sobre a organização parceira</p>

                <div class="form-group">
                    <label for="nome" class="form-label">
                        Nome da Instituição / ONG <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        class="form-control"
                        value="{{ old('nome') }}" 
                        placeholder="Ex.: Instituto Saber e Leitura"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cnpj" class="form-label">CNPJ <span class="required-mark">*</span></label>
                        <input 
                            type="text" 
                            name="cnpj" 
                            id="cnpj" 
                            class="form-control"
                            value="{{ old('cnpj') }}" 
                            placeholder="00.000.000/0000-00"
                            maxlength="18"
                            required
                        >
                        <span class="form-hint">Máscara padrão: 00.000.000/0000-00. Dado fixo após o cadastro.</span>
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone (Opcional)</label>
                        <input 
                            type="text" 
                            name="telefone" 
                            id="telefone" 
                            class="form-control"
                            value="{{ old('telefone') }}" 
                            placeholder="(11) 99999-9999"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_contato" class="form-label">E-mail de Contato Público (Opcional)</label>
                    <input 
                        type="email" 
                        name="email_contato" 
                        id="email_contato" 
                        class="form-control"
                        value="{{ old('email_contato') }}" 
                        placeholder="contato@instituicao.org"
                    >
                    <span class="form-hint">E-mail visível publicamente nos pontos de coleta desta ONG.</span>
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição (Opcional)</label>
                    <textarea 
                        name="descricao" 
                        id="descricao" 
                        rows="3" 
                        class="form-control"
                        placeholder="Breve resumo da missão e das atividades da ONG..."
                    >{{ old('descricao') }}</textarea>
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-section">
                <h2 class="form-section-title">Localização da Sede</h2>
                <p class="form-section-subtitle">Endereço institucional e estado da organização</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cep" class="form-label">CEP (Opcional)</label>
                        <input 
                            type="text" 
                            name="cep" 
                            id="cep" 
                            class="form-control"
                            value="{{ old('cep') }}" 
                            placeholder="00000-000"
                        >
                    </div>

                    <div class="form-group">
                        <label for="estado" class="form-label">Estado / UF (Opcional)</label>
                        <input 
                            type="text" 
                            name="estado" 
                            id="estado" 
                            class="form-control"
                            value="{{ old('estado') }}" 
                            placeholder="SP"
                            maxlength="2"
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade (Opcional)</label>
                        <input 
                            type="text" 
                            name="cidade" 
                            id="cidade" 
                            class="form-control"
                            value="{{ old('cidade') }}" 
                            placeholder="São Paulo"
                        >
                    </div>

                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro (Opcional)</label>
                        <input 
                            type="text" 
                            name="bairro" 
                            id="bairro" 
                            class="form-control"
                            value="{{ old('bairro') }}" 
                            placeholder="Centro"
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="endereco" class="form-label">Endereço / Logradouro (Opcional)</label>
                        <input 
                            type="text" 
                            name="endereco" 
                            id="endereco" 
                            class="form-control"
                            value="{{ old('endereco') }}" 
                            placeholder="Av. Paulista, Rua das Flores..."
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número (Opcional)</label>
                        <input 
                            type="text" 
                            name="numero" 
                            id="numero" 
                            class="form-control"
                            value="{{ old('numero') }}" 
                            placeholder="123 ou S/N"
                        >
                    </div>

                    <div class="form-group">
                        <label for="complemento" class="form-label">Complemento (Opcional)</label>
                        <input 
                            type="text" 
                            name="complemento" 
                            id="complemento" 
                            class="form-control"
                            value="{{ old('complemento') }}" 
                            placeholder="Sala 101, Bloco B"
                        >
                    </div>
                </div>
            </div>

            <hr class="form-divider">

<div class="form-section">
    <h2 class="form-section-title">Acesso ao Sistema</h2>

    <p class="form-section-subtitle">
        As credenciais de acesso serão geradas automaticamente
        e enviadas para o e-mail informado.
    </p>

    <div class="form-group">
        <label for="email" class="form-label">
            E-mail de Login <span class="required-mark">*</span>
        </label>

        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ old('email') }}"
            placeholder="login@ong.org"
            required
        >

        <span class="form-hint">
            Uma senha temporária será gerada e enviada para este endereço.
        </span>
    </div>
</div>

            <div class="form-actions">
                <a href="{{ route('admin.ongs.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Cadastrar ONG
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const cnpjInput = document.getElementById('cnpj');
    if (cnpjInput) {
        cnpjInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 14);
            if (v.length > 12) {
                v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2})$/, '$1.$2.$3/$4-$5');
            } else if (v.length > 8) {
                v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4})$/, '$1.$2.$3/$4');
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{3})(\d{0,3})$/, '$1.$2.$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,3})$/, '$1.$2');
            }
            e.target.value = v;
        });
    }

    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 8);
            if (v.length > 5) {
                v = v.replace(/^(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = v;
        });
    }

    const telInput = document.getElementById('telefone');
    if (telInput) {
        telInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
            }
            e.target.value = v;
        });
    }
</script>
@endsection
