# 📚 EcoPoint - Sistema de Mapeamento de Coleta de Livros e Apostilas Acadêmicas

Guia oficial de arquitetura, estrutura inicial e orientações para a equipe de desenvolvimento.

---

## 🎯 1. Objetivo do Projeto

O **EcoPoint** é uma plataforma acadêmica desenvolvida em **PHP (Laravel) e MySQL** com foco no mapeamento e divulgação de pontos de coleta para doação e redistribuição de livros didáticos, acadêmicos e apostilas escolares/vestibulares.

### Perfis de Acesso

| Perfil | Acesso | Principais Responsabilidades |
| :--- | :--- | :--- |
| **Visitante / Público** | Livre (sem login) | Consultar pontos de coleta no mapa/lista, visualizar horários, materiais aceitos e dados institucionais das ONGs. |
| **ONG (Institucional)** | Autenticado | Cadastrar, editar e excluir seus próprios pontos de coleta; atualizar informações de seu perfil institucional. |
| **Administrador** | Autenticado | Gerenciamento geral da plataforma; cadastrar ONGs; consultar, editar e ativar/desativar organizações cadastradas. |

---

## 🏗️ 2. Arquitetura e Organização de Pastas

O projeto adota o padrão **MVC (Model-View-Controller)** com separação explícita de contextos por perfil de usuário:

```text
laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Ações exclusivas do Administrador
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── OngController.php
│   │   │   ├── Ong/                      # Ações exclusivas da ONG autenticada
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PerfilController.php
│   │   │   │   └── PontoDeColetaController.php
│   │   │   └── Publico/                  # Ações abertas para visitantes
│   │   │       ├── HomeController.php
│   │   │       ├── OngController.php
│   │   │       └── PontoDeColetaController.php
│   │   └── Middleware/
│   │       └── VerificarPerfil.php       # Proteção de rotas ('perfil:admin' e 'perfil:ong')
│   └── Models/
│       ├── User.php                      # Model de autenticação com campo 'role'
│       ├── Ong.php                       # Dados institucionais da ONG
│       ├── PontoDeColeta.php             # Local físico de coleta
│       └── MaterialAceito.php            # Tipos de materiais recolhidos
├── database/
│   ├── migrations/                       # Esquema das tabelas do MySQL
│   └── seeders/
│       ├── DatabaseSeeder.php            # Seeder mestre (cria Admin padrão)
│       └── MaterialAceitoSeeder.php      # Categorias iniciais de livros/apostilas
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Template base padrão
│       ├── admin/                        # Telas do Administrador
│       ├── ong/                          # Telas da ONG
│       └── publico/                      # Telas públicas de consulta
└── routes/
    └── web.php                           # Mapeamento organizado das rotas
```

---

## 🗄️ 3. Banco de Dados e Modelagem (MySQL)

### Diagrama de Relacionamentos (ER)

```
[ users ]
   │ 1
   │ 
   │ 1 (role = 'ong')
[ ongs ]
   │ 1
   │
   │ N
[ pontos_de_coleta ]
   │ N
   │
   │ N (via material_ponto_coleta)
[ materiais_aceitos ]
```

### Detalhamento das Tabelas e Migrations

1. **`users`** (`0001_01_01_000000_create_users_table.php`):
   - Campos: `id`, `name`, `email`, `role`, `password`, `timestamps`.
   - Coluna `role`: Aceita `'admin'` ou `'ong'`.

2. **`ongs`** (`..._create_ongs_table.php`):
   - Chave estrangeira: `user_id` &rarr; vinculada a `users(id)` com remoção em cascata (`cascade`).
   - Campos: `nome`, `cnpj`, `telefone`, `email_contato`, `descricao`, `ativo` (booleano para ativação/desativação).

3. **`pontos_de_coleta`** (`..._create_pontos_de_coleta_table.php`):
   - Chave estrangeira: `ong_id` &rarr; vinculada a `ongs(id)` com remoção em cascata (`cascade`).
   - Campos de endereço: `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`.
   - Coordenadas geográficas: `latitude` e `longitude` (decimais nulos, preparados para integração com mapa).
   - Informações de atendimento: `horario_funcionamento`, `telefone_contato`, `ativo`.

4. **`materiais_aceitos`** (`..._create_materiais_aceitos_table.php`):
   - Catálogo de itens aceitos: `nome` (ex.: *Livros Didáticos, Apostilas Pré-Vestibular*) e `descricao`.

5. **`material_ponto_coleta`** (`..._create_material_ponto_coleta_table.php`):
   - Tabela intermediária (Pivot N:N) ligando `ponto_de_coleta_id` e `material_aceito_id`.

---

## 🧠 4. Eloquent Models e Métodos de Relacionamento

### `App\Models\User`
- `$user->ong`: Retorna a instância da ONG vinculada (`hasOne`).
- `$user->isAdmin()`: Retorna `true` se `role === 'admin'`.
- `$user->isOng()`: Retorna `true` se `role === 'ong'`.

### `App\Models\Ong`
- `$ong->user`: Retorna o usuário de acesso (`belongsTo`).
- `$ong->pontosDeColeta`: Retorna a coleção de pontos cadastrados pela ONG (`hasMany`).

### `App\Models\PontoDeColeta`
- `$ponto->ong`: Retorna a ONG responsável pelo ponto (`belongsTo`).
- `$ponto->materiaisAceitos`: Retorna os materiais acadêmicos aceitos no local (`belongsToMany`).

### `App\Models\MaterialAceito`
- `$material->pontosDeColeta`: Retorna todos os pontos que recebem esse tipo de material (`belongsToMany`).

---

## 🛡️ 5. Middlewares e Proteção de Rotas

Foi criado o middleware `App\Http\Middleware\VerificarPerfil`, registrado no [`bootstrap/app.php`](file:///c:/Users/hyago/Downloads/PROJETO%20PI/EcoPoint/laravel/bootstrap/app.php) sob o alias `'perfil'`.

### Como utilizar nas rotas:
```php
// Rotas exclusivas de ONG (usuário precisa estar logado E ter role 'ong')
Route::prefix('ong')->name('ong.')->middleware(['auth', 'perfil:ong'])->group(function () {
    // Rotas da ONG aqui...
});

// Rotas exclusivas de Administrador (usuário precisa estar logado E ter role 'admin')
Route::prefix('admin')->name('admin.')->middleware(['auth', 'perfil:admin'])->group(function () {
    // Rotas do Admin aqui...
});
```

---

## 🏢 6. Módulo da ONG (Implementado)

### 1. Painel Inicial (Dashboard)
- **Rota:** `GET /ong/dashboard` (`route('ong.dashboard')`)
- **Controller:** `App\Http\Controllers\Ong\DashboardController@index`
- **View:** `resources/views/ong/dashboard.blade.php`
- **CSS:** `public/css/ong/dashboard.css`
- **Recursos Exibidos:**
  - Quantidade total de pontos de coleta cadastrados pela instituição.
  - Quantidade de pontos de coleta ativos no momento.
  - Status institucional (Ativa / Inativa).
  - Tabela com os últimos pontos de coleta cadastrados pela ONG.
  - Acessos rápidos para novo ponto, gerenciamento de pontos e perfil institucional.

### 2. Gerenciamento de Pontos de Coleta (CRUD)
- **Rotas:**
  - `GET /ong/pontos` (`route('ong.pontos.index')`): Lista paginada dos pontos de coleta da própria ONG.
  - `GET /ong/pontos/criar` (`route('ong.pontos.create')`): Formulário de cadastro com seleção de materiais aceitos.
  - `POST /ong/pontos` (`route('ong.pontos.store')`): Salva o ponto associado à ONG e sincroniza a pivot `material_ponto_coleta`.
  - `GET /ong/pontos/{ponto}/editar` (`route('ong.pontos.edit')`): Formulário de edição com dados existentes e materiais marcados.
  - `PUT /ong/pontos/{ponto}` (`route('ong.pontos.update')`): Atualiza os dados e sincroniza os materiais aceitos.
  - `DELETE /ong/pontos/{ponto}` (`route('ong.pontos.destroy')`): Exclui o ponto de coleta.
- **Segurança e Isolamento:** Cada ONG só pode visualizar, editar ou excluir os pontos que pertençam à sua própria organização (`ong_id === auth()->user()->ong->id`). Qualquer tentativa de gerenciar pontos de outra instituição retorna erro `403 Forbidden`.
- **View:** `resources/views/ong/pontos/` (`index.blade.php`, `create.blade.php`, `edit.blade.php`)
- **CSS:** `public/css/ong/pontos.css`

### 3. Perfil Institucional
- **Rotas:**
  - `GET /ong/perfil` (`route('ong.perfil.edit')`): Visualização do perfil da instituição.
  - `PUT /ong/perfil` (`route('ong.perfil.update')`): Atualização de nome, CNPJ, telefone, e-mail público, descrição e alteração de senha.
- **View:** `resources/views/ong/perfil/edit.blade.php`
- **CSS:** `public/css/ong/perfil-edit.css`

---

## 🧪 7. Como Executar os Testes Automatizados

O projeto conta com suíte de testes em PHPUnit / Laravel Feature Tests:

```bash
# Executar todos os testes da aplicação:
php artisan test

# Executar apenas os testes da área da ONG:
php artisan test --filter=OngPontoDeColetaTest

# Executar os testes da área do Administrador:
php artisan test --filter=AdminOngTest

# Executar os testes de Autenticação (Login/Logout):
php artisan test --filter=AuthTest
```

---

## 🚀 8. Como Rodar o Projeto Localmente

### Pré-requisitos
- **PHP 8.2+** instalado.
- **MySQL** rodando (ex.: XAMPP, Laragon ou Docker).
- **Composer** instalado.

### Passo a Passo

1. **Configurar o Banco de Dados:**
   No MySQL, crie a base de dados:
   ```sql
   CREATE DATABASE ecopoint CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Verificar o `.env`:**
   O arquivo `.env` já está pré-configurado:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecopoint
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Ajuste o `DB_PASSWORD` caso seu MySQL possua senha).*

3. **Executar Migrations e Seeders:**
   No terminal, dentro da pasta `laravel/`:
   ```bash
   php artisan migrate --seed
   ```
   Isso criará todas as tabelas e cadastrará:
   - **Administrador padrão**:
     - **E-mail:** `admin@ecopoint.com`
     - **Senha:** `admin123`
   - **Categorias essenciais de materiais aceitos** (Livros Didáticos, Apostilas ENEM, Universitários, Literatura, etc.).

4. **Iniciar o Servidor de Desenvolvimento:**
   ```bash
   php artisan serve
   ```
   Acesse no navegador: `http://127.0.0.1:8000`

---

## 📌 7. Próximos Passos Recomendados para o Time

Ao implementar cada funcionalidade, sigam a ordem abaixo para manter a simplicidade:

1. **Autenticação (Login / Logout)**:
   - Utilizar a autenticação padrão do Laravel (ex: Laravel Breeze ou controllers manuais de Auth).
2. **Área da ONG**:
   - Implementar formulário de edição do perfil (`PerfilController@edit` e `@update`).
   - Implementar o CRUD de pontos da própria ONG (`PontoDeColetaController`).
3. **Área do Administrador**:
   - Implementar cadastro de novas ONGs criando simultaneamente o `User` e a `Ong`.
   - Implementar ativação/desativação da ONG (`toggleStatus`).
4. **Área Pública**:
   - Listar pontos ativos com filtro por cidade ou tipo de material acadêmico.
   - Detalhes do ponto com endereço e contatos.
5. **Integração com Mapa (Futuro)**:
   - Usar Leaflet.js ou OpenStreetMap (gratuitos e sem necessidade de chave de API paga) utilizando as colunas `latitude` e `longitude`.

