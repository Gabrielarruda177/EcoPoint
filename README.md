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
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Ações exclusivas do Administrador
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── OngController.php
│   │   │   ├── Auth/                     # Login e Logout
│   │   │   │   └── LoginController.php
│   │   │   ├── Ong/                      # Ações da ONG autenticada
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
│       ├── DatabaseSeeder.php            # Seeder mestre (Admin, Materiais e ONG padrão)
│       ├── AdminUserSeeder.php           # Administrador inicial
│       ├── MaterialAceitoSeeder.php      # Categorias iniciais de livros/apostilas
│       └── OngSeeder.php                 # ONG inicial para testes (ong@ecopoint.com)
├── public/
│   └── css/                              # Estilos CSS modulares separados por área
│       ├── admin/
│       ├── auth/
│       ├── ong/                          # CSS da ONG (dashboard, pontos, perfil)
│       └── publico/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Template base padrão
│       ├── admin/                        # Telas do Administrador
│       ├── auth/                         # Telas de Login
│       ├── ong/                          # Telas da ONG (Dashboard, Pontos, Perfil)
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

---

## 🏢 4. Módulo da ONG (Implementado)

### 1. Painel Inicial (Dashboard)
- **Rota:** `GET /ong/dashboard` (`route('ong.dashboard')`)
- **Controller:** `App\Http\Controllers\Ong\DashboardController@index`
- **View:** `resources/views/ong/dashboard.blade.php`
- **CSS:** `public/css/ong/dashboard.css`
- **Recursos:** Métricas de pontos totais e ativos, status da organização, tabela de pontos recentes e atalhos rápidos.

### 2. Gerenciamento de Pontos de Coleta (CRUD)
- **Rotas:**
  - `GET /ong/pontos` (`route('ong.pontos.index')`): Lista paginada dos pontos de coleta da própria ONG.
  - `GET /ong/pontos/criar` (`route('ong.pontos.create')`): Formulário de cadastro com seleção de materiais aceitos.
  - `POST /ong/pontos` (`route('ong.pontos.store')`): Salva o ponto associado à ONG e sincroniza a pivot `material_ponto_coleta`.
  - `GET /ong/pontos/{ponto}/editar` (`route('ong.pontos.edit')`): Formulário de edição com dados existentes e materiais marcados.
  - `PUT /ong/pontos/{ponto}` (`route('ong.pontos.update')`): Atualiza os dados e sincroniza os materiais aceitos.
  - `DELETE /ong/pontos/{ponto}` (`route('ong.pontos.destroy')`): Exclui o ponto de coleta.
- **Segurança e Isolamento:** Cada ONG só pode gerenciar estritamente os pontos que pertençam à sua própria organização (`ong_id === auth()->user()->ong->id`). Qualquer tentativa de manipular ponto de outra instituição retorna erro `403 Forbidden`.
- **View:** `resources/views/ong/pontos/` (`index.blade.php`, `create.blade.php`, `edit.blade.php`)
- **CSS:** `public/css/ong/pontos.css`

### 3. Perfil Institucional
- **Rotas:**
  - `GET /ong/perfil` (`route('ong.perfil.edit')`): Visualização do perfil da instituição.
  - `PUT /ong/perfil` (`route('ong.perfil.update')`): Atualização de nome, CNPJ, telefone, e-mail público, descrição e alteração de senha.
- **View:** `resources/views/ong/perfil/edit.blade.php`
- **CSS:** `public/css/ong/perfil-edit.css`

---

## 🧪 5. Como Executar os Testes Automatizados

O projeto conta com suíte completa de testes em PHPUnit / Laravel Feature Tests (27 testes passando):

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

## 🚀 6. Como Rodar o Projeto Localmente

### Pré-requisitos
- **PHP 8.2+** (ou Laragon PHP 8.3).
- **MySQL** rodando (ex.: XAMPP, Laragon ou Docker).
- **Composer** instalado.

### Passo a Passo

1. **Configurar o Banco de Dados:**
   No MySQL, crie a base de dados:
   ```sql
   CREATE DATABASE ecopoint CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Executar Migrations e Seeders:**
   No terminal:
   ```bash
   php artisan migrate --seed
   ```
   Credenciais padrão cadastradas para teste:
   - **Administrador:** `admin@ecopoint.com` | Senha: `admin123`
   - **ONG:** `ong@ecopoint.com` | Senha: `ong123`

3. **Iniciar o Servidor:**
   ```bash
   php artisan serve
   ```
   Acesse no navegador: `http://127.0.0.1:8000`
