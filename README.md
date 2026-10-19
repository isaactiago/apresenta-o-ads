# 📋 OrganizaTarefas — Symfony 8.1

Aplicação web de gerenciamento de tarefas construída com **Symfony 8.1**, **PHP 8.4** e **MySQL 5.7**, containerizada com **Docker**.

---

## 🚀 Tecnologias

| Camada | Tecnologia |
|---|---|
| Framework | Symfony 8.1 |
| Linguagem | PHP 8.4 |
| Banco de dados | MySQL 5.7 |
| ORM | Doctrine ORM 3.x |
| Templates | Twig |
| Frontend | Symfony AssetMapper + UX Turbo |
| Containerização | Docker + Docker Compose |

---

## ✨ Funcionalidades

- ✅ **Listar tarefas** — exibe todas as tarefas ordenadas da mais recente para a mais antiga
- ✅ **Criar tarefa** — cadastro com título (obrigatório) e descrição (opcional)
- ✅ **Concluir tarefa** — marca uma tarefa como concluída
- ✅ **Reabrir tarefa** — reabre uma tarefa já concluída
- ✅ **Excluir tarefa** — remove permanentemente uma tarefa

---

## 🗂️ Estrutura do Projeto

```
src/
├── Controller/
│   ├── ListTasksController.php      # GET  /
│   ├── CreateTaskController.php     # POST /tarefas
│   ├── CompleteTaskController.php   # POST /tarefas/{id}/concluir
│   ├── ReopenTaskController.php     # POST /tarefas/{id}/reabrir
│   └── DeleteTaskController.php     # POST /tarefas/{id}/excluir
├── Entity/
│   └── Task.php                     # Entidade principal
├── Dto/
│   └── TaskInput.php                # DTO de entrada do formulário
├── Form/
│   └── TaskType.php                 # Formulário Symfony
├── Repository/
│   └── TaskRepository.php           # Queries customizadas
└── Service/
    └── TaskManager.php              # Regras de negócio (criar, concluir, reabrir, excluir)
```

---

## 🗄️ Modelo de Dados

### Tabela `task`

| Coluna | Tipo | Descrição |
|---|---|---|
| `id` | INT AUTO_INCREMENT | Chave primária |
| `title` | VARCHAR(120) | Título da tarefa (obrigatório) |
| `description` | LONGTEXT | Descrição da tarefa (opcional) |
| `completed` | TINYINT | `0` = pendente / `1` = concluída |
| `created_at` | DATETIME | Data de criação |

---

## ⚙️ Configuração e Execução

### Pré-requisitos

- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/) instalados

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd aboutSymfony
```

### 2. Configure as variáveis de ambiente

Copie o `.env` e ajuste se necessário (as credenciais padrão já funcionam com o Docker Compose):

```bash
cp .env .env.local
```

As variáveis principais:

```dotenv
DATABASE_URL="mysql://usuario:senha@database:3306/organiza_tarefas?serverVersion=5.7&charset=utf8mb4"

MYSQL_USER=usuario
MYSQL_PASSWORD=senha
MYSQL_DATABASE=organiza_tarefas
MYSQL_ROOT_PASSWORD=rootpassword
```

### 3. Suba os containers

```bash
docker compose up -d --build
```

Isso irá iniciar:
- **`database`** — MySQL 5.7 na porta `3306`
- **`app`** — PHP 8.4 com servidor embutido na porta `8080`

> O serviço `app` aguarda automaticamente o banco estar saudável antes de iniciar.

### 4. Execute as migrations

```bash
docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
```

### 5. Acesse a aplicação

```
http://localhost:8080
```

---

## 🛠️ Comandos Úteis

```bash
# Ver logs dos containers
docker compose logs -f

# Acessar o terminal do container PHP
docker compose exec app bash

# Limpar cache do Symfony
docker compose exec app php bin/console cache:clear

# Criar uma nova migration após alterar entidades
docker compose exec app php bin/console make:migration

# Listar rotas registradas
docker compose exec app php bin/console debug:router

# Parar e remover containers (mantém o volume do banco)
docker compose down

# Parar e remover containers E o volume do banco (reset completo)
docker compose down -v
```

---

## 📁 Arquivos Docker

| Arquivo | Descrição |
|---|---|
| [`Dockerfile`](./Dockerfile) | Imagem PHP 8.4-cli com extensões necessárias |
| [`compose.yaml`](./compose.yaml) | Orquestração dos serviços `app` e `database` |

---

## 🏗️ Arquitetura

O projeto segue os princípios do **Symfony Way**:

- **Controllers invocáveis** (`__invoke`) — um controller por arquivo, cada um responsável por uma única ação
- **DTO** para transporte de dados do formulário até o service
- **Service Layer** (`TaskManager`) — toda a lógica de negócio centralizada, isolada dos controllers
- **Repository** com método customizado (`findAllNewestFirst`) para queries específicas
- **Migrations versionadas** com Doctrine Migrations

---

## 📄 Licença

Projeto proprietário — todos os direitos reservados.
