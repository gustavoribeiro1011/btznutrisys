# BTZ NutriSys

Sistema web completo para gerenciamento e projeção de consumo de ração em granjas de frango de corte, com controle de acesso por empresa e usuário.

## 📋 Visão Geral

O BTZ NutriSys é uma aplicação desenvolvida para atender ao desafio técnico da Grupo BTZ, oferecendo uma solução robusta para:

- Gerenciamento de usuários por empresa
- Cadastro de dados de consumo de ração por semana
- Controle de cronograma de abates
- Cálculo automático de projeção de consumo de ração
- Relatórios detalhados com exportação

## 🚀 Tecnologias Utilizadas

### Backend
- **PHP 8.2+**
- **Laravel 12** 
- **PostgreSQL 17** 
- **API RESTful**

### Frontend
- **TailwindCSS**

### Versionamento
- **Git** com repositório no GitHub

## 📦 Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

- PHP 8.2 ou superior
- Composer
- PostgreSQL 17
- Node.js

### Configuração do PHP

Verifique se as seguintes extensões estão habilitadas no seu `php.ini`:

```ini
extension=pgsql
extension=pdo_pgsql
```

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/gustavoribeiro1011/btznutrisys.git
cd btznutrisys
```

### 2. Instale as dependências do backend

```bash
composer install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados

Edite o arquivo `.env` com suas credenciais do PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=btznutrisys
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as migrações

```bash
php artisan migrate
```

### 6. Inicie o servidor

```bash
php artisan serve
```

O sistema estará disponível em `http://localhost:8000`


## 📝 Decisões Técnicas

### Arquitetura
- **API RESTful**: Separação clara entre backend e frontend
- **Repository Pattern**: Abstração da camada de dados
- **Service Layer**: Lógica de negócio centralizada

### Autenticação
- **Laravel Sanctum**: Token-based authentication
- **Middleware**: Proteção de rotas por empresa

### Performance
- **Eloquent ORM**: Com otimizações de query
- **Redis**: Para cache (em produção)
- **Queue System**: Para processamentos pesados



## 📞 Contato

**Desenvolvedor**: Gustavo Ribeiro  
**Email**: [gustavoribeiro1011@gmail.com]  
**LinkedIn**: [(https://www.linkedin.com/in/gustavo-ribeiro-258536364/)]

## 📄 Licença

Este projeto foi desenvolvido como parte do desafio técnico da Grupo BTZ.

---

**Grupo BTZ**  
R. Mar Vermelho, 35 - Cláudia, Londrina - PR, 86050-420  
(43) 3272 8000  
grupobtz.com.br
