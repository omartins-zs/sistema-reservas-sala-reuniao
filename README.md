# Sistema de Reservas de Salas de Reunião

Sistema completo desenvolvido em Laravel para gerenciamento de reservas de salas de reunião, permitindo verificação de disponibilidade em tempo real e prevenção de conflitos de horário.

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Instalação](#instalação)
- [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
- [Executando as Migrations](#executando-as-migrations)
- [Rotas da API](#rotas-da-api)
- [Exemplos de Uso](#exemplos-de-uso)
- [Arquitetura e Decisões Técnicas](#arquitetura-e-decisões-técnicas)
- [Tratamento de Erros](#tratamento-de-erros)

---

## 🎯 Sobre o Projeto

Sistema completo de gerenciamento de reservas de salas de reunião desenvolvido como teste técnico, demonstrando boas práticas de desenvolvimento Laravel, arquitetura limpa e testes automatizados.

### ✨ Funcionalidades

- ✅ CRUD completo de Usuários, Salas e Reservas
- ✅ API RESTful com validações robustas
- ✅ Interface web responsiva com Tailwind CSS (Hyper UI)
- ✅ Verificação de conflitos de horário em tempo real
- ✅ Controle de horário de funcionamento das salas
- ✅ Validação de disponibilidade antes de criar reservas
- ✅ Testes automatizados com Pest 4 (64+ testes)
- ✅ Documentação completa com Postman Collection

### 🏗️ Arquitetura

- **Controllers Enxutos**: Apenas orquestração de chamadas
- **Service Layer**: Toda lógica de negócio centralizada
- **Form Requests**: Validações com mensagens amigáveis
- **Custom Exceptions**: Tratamento de erros padronizado
- **Factories e Seeders**: Dados de teste organizados

### 🛠️ Tecnologias

- Laravel 12
- PHP 8.2+
- MySQL
- Tailwind CSS (Hyper UI)
- Alpine.js
- Pest 4 (Testes)
- Postman (API Testing)

### 📊 Testes

- 64+ testes automatizados
- Cobertura de Models, Services, Controllers (API e Web)
- Testes de integração e unitários
- Factories para geração de dados de teste

### 📚 Documentação

- README completo com instruções de instalação
- Postman Collection com exemplos de todas as rotas
- Comentários no código seguindo padrões PSR

---

---

## 📁 Estrutura do Projeto

```
app/
├── Exceptions/
│   └── ConflitoHorarioException.php    # Exception customizada para conflitos
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── ReservaController.php   # Controller de reservas
│   │       ├── SalaController.php      # Controller de salas
│   │       └── UsuarioController.php    # Controller de usuários
│   └── Requests/
│       ├── StoreReservaRequest.php      # Validação de criação de reserva
│       ├── UpdateReservaRequest.php     # Validação de atualização de reserva
│       ├── StoreSalaRequest.php        # Validação de criação de sala
│       ├── UpdateSalaRequest.php       # Validação de atualização de sala
│       ├── StoreUsuarioRequest.php     # Validação de criação de usuário
│       └── UpdateUsuarioRequest.php    # Validação de atualização de usuário
├── Models/
│   ├── Reserva.php                     # Model de reservas
│   ├── Sala.php                        # Model de salas
│   └── Usuario.php                     # Model de usuários
└── Services/
    ├── ReservaService.php              # Lógica de negócio de reservas
    ├── SalaService.php                 # Lógica de negócio de salas
    └── UsuarioService.php              # Lógica de negócio de usuários

database/
└── migrations/
    ├── 2025_12_28_150719_create_usuarios_table.php
    ├── 2025_12_28_150721_create_salas_table.php
    └── 2025_12_28_150722_create_reservas_table.php

routes/
└── api.php                             # Rotas da API
```

---

## 🚀 Instalação

### Pré-requisitos

- PHP 8.2 ou superior
- Composer
- MySQL 5.7+ ou MariaDB 10.3+
- Extensões PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

### Passos

1. **Clone o repositório** (ou navegue até a pasta do projeto)

2. **Instale as dependências:**
```bash
composer install
```

3. **Configure o arquivo `.env`:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure as variáveis de ambiente no arquivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. **Inicie o servidor:**
```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`

---

## 🗄 Configuração do Banco de Dados

### Criando o Banco de Dados

No MySQL, execute:

```sql
CREATE DATABASE sistema_reservas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 📊 Executando as Migrations

Execute as migrations para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

Isso criará as seguintes tabelas:

- **usuarios**: Armazena os funcionários/usuários do sistema
- **salas**: Armazena as salas de reunião disponíveis
- **reservas**: Armazena as reservas realizadas

### Populando o Banco com Dados de Exemplo (Seeders)

O projeto inclui seeders para popular o banco de dados com dados de exemplo, facilitando testes e demonstração:

```bash
php artisan db:seed
```

Ou execute migrations e seeders juntos:

```bash
php artisan migrate --seed
```

Os seeders criam:
- **5 usuários** de exemplo (diferentes departamentos)
- **5 salas** de exemplo (diferentes capacidades e localizações)
- **6 reservas** de exemplo (hoje e amanhã)

**Nota**: Os seeders criam reservas para a data atual e do dia seguinte. Se você executar os seeders em dias diferentes, as reservas serão criadas para as datas correspondentes.

---

## 🔌 Rotas da API

Todas as rotas da API estão prefixadas com `/api`.

### Usuários

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/usuarios` | Lista todos os usuários |
| POST | `/api/usuarios` | Cria um novo usuário |
| GET | `/api/usuarios/{id}` | Exibe um usuário específico |
| PUT | `/api/usuarios/{id}` | Atualiza um usuário |
| DELETE | `/api/usuarios/{id}` | Remove um usuário |

### Salas

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/salas` | Lista todas as salas |
| POST | `/api/salas` | Cria uma nova sala |
| GET | `/api/salas/{id}` | Exibe uma sala específica |
| PUT | `/api/salas/{id}` | Atualiza uma sala |
| DELETE | `/api/salas/{id}` | Remove uma sala |

### Reservas

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/reservas` | Lista todas as reservas |
| POST | `/api/reservas` | Cria uma nova reserva |
| GET | `/api/reservas/{id}` | Exibe uma reserva específica |
| PUT | `/api/reservas/{id}` | Atualiza uma reserva |
| DELETE | `/api/reservas/{id}` | Remove uma reserva |
| GET | `/api/reservas/sala/{salaId}` | Lista reservas de uma sala |
| GET | `/api/reservas/usuario/{usuarioId}` | Lista reservas de um usuário |
| POST | `/api/reservas/verificar-disponibilidade` | Verifica disponibilidade |

### 📬 Collection do Postman

Uma collection completa do Postman está disponível no arquivo `Sistema_Reservas_Salas.postman_collection.json` na raiz do projeto.

**Como importar:**

1. Abra o Postman
2. Clique em **Import** (canto superior esquerdo)
3. Selecione o arquivo `Sistema_Reservas_Salas.postman_collection.json`
4. A collection será importada com todas as rotas e exemplos

**Variáveis de Ambiente:**

A collection inclui as seguintes variáveis que você pode configurar:

- `base_url`: URL base da API (padrão: `http://localhost:8000`)
- `usuario_id`: ID de exemplo de usuário (padrão: `1`)
- `sala_id`: ID de exemplo de sala (padrão: `1`)
- `reserva_id`: ID de exemplo de reserva (padrão: `1`)

**Para configurar as variáveis:**

1. Na collection, clique em **Variables**
2. Altere os valores conforme necessário
3. Ou crie um Environment no Postman com essas variáveis

**Todas as requisições incluem:**

- ✅ Headers configurados (`Content-Type: application/json`)
- ✅ Body de exemplo para POST/PUT
- ✅ Parâmetros de URL configurados
- ✅ Descrições detalhadas de cada endpoint

---

## 💡 Exemplos de Uso

### 1. Criar um Usuário

**Request:**
```bash
POST /api/usuarios
Content-Type: application/json

{
    "nome": "João Silva",
    "email": "joao.silva@empresa.com",
    "departamento": "TI",
    "telefone": "(11) 99999-9999"
}
```

**Response (201):**
```json
{
    "status": "success",
    "message": "Usuário criado com sucesso.",
    "data": {
        "id": 1,
        "nome": "João Silva",
        "email": "joao.silva@empresa.com",
        "departamento": "TI",
        "telefone": "(11) 99999-9999",
        "created_at": "2025-12-28T15:00:00.000000Z",
        "updated_at": "2025-12-28T15:00:00.000000Z"
    }
}
```

### 2. Criar uma Sala

**Request:**
```bash
POST /api/salas
Content-Type: application/json

{
    "nome": "Sala de Reunião A",
    "capacidade": 10,
    "localizacao": "1º Andar - Ala Norte"
}
```

**Response (201):**
```json
{
    "status": "success",
    "message": "Sala criada com sucesso.",
    "data": {
        "id": 1,
        "nome": "Sala de Reunião A",
        "capacidade": 10,
        "localizacao": "1º Andar - Ala Norte",
        "created_at": "2025-12-28T15:00:00.000000Z",
        "updated_at": "2025-12-28T15:00:00.000000Z"
    }
}
```

### 3. Verificar Disponibilidade

**Request:**
```bash
POST /api/reservas/verificar-disponibilidade
Content-Type: application/json

{
    "sala_id": 1,
    "data_reserva": "2025-12-29",
    "horario_inicio": "14:00",
    "horario_fim": "15:00"
}
```

**Response (200) - Disponível:**
```json
{
    "status": "success",
    "message": "Sala disponível no período solicitado.",
    "data": {
        "disponivel": true
    }
}
```

**Response (200) - Indisponível:**
```json
{
    "status": "success",
    "message": "Sala não disponível no período solicitado.",
    "data": {
        "disponivel": false
    }
}
```

### 4. Criar uma Reserva

**Request:**
```bash
POST /api/reservas
Content-Type: application/json

{
    "usuario_id": 1,
    "sala_id": 1,
    "data_reserva": "2025-12-29",
    "horario_inicio": "14:00",
    "horario_fim": "15:00"
}
```

**Response (201) - Sucesso:**
```json
{
    "status": "success",
    "message": "Reserva criada com sucesso.",
    "data": {
        "id": 1,
        "usuario_id": 1,
        "sala_id": 1,
        "data_reserva": "2025-12-29",
        "horario_inicio": "14:00",
        "horario_fim": "15:00",
        "usuario": {
            "id": 1,
            "nome": "João Silva",
            "email": "joao.silva@empresa.com"
        },
        "sala": {
            "id": 1,
            "nome": "Sala de Reunião A",
            "capacidade": 10
        },
        "created_at": "2025-12-28T15:00:00.000000Z",
        "updated_at": "2025-12-28T15:00:00.000000Z"
    }
}
```

**Response (409) - Conflito de Horário:**
```json
{
    "status": "error",
    "message": "A sala já está reservada neste horário."
}
```

### 5. Listar Reservas de uma Sala

**Request:**
```bash
GET /api/reservas/sala/1
```

**Response (200):**
```json
{
    "status": "success",
    "message": "Reservas da sala listadas com sucesso.",
    "data": [
        {
            "id": 1,
            "usuario_id": 1,
            "sala_id": 1,
            "data_reserva": "2025-12-29",
            "horario_inicio": "14:00",
            "horario_fim": "15:00",
            "usuario": {
                "id": 1,
                "nome": "João Silva",
                "email": "joao.silva@empresa.com"
            },
            "sala": {
                "id": 1,
                "nome": "Sala de Reunião A",
                "capacidade": 10
            }
        }
    ]
}
```

### 6. Listar Reservas de um Usuário

**Request:**
```bash
GET /api/reservas/usuario/1
```

**Response (200):**
```json
{
    "status": "success",
    "message": "Reservas do usuário listadas com sucesso.",
    "data": [
        {
            "id": 1,
            "usuario_id": 1,
            "sala_id": 1,
            "data_reserva": "2025-12-29",
            "horario_inicio": "14:00",
            "horario_fim": "15:00",
            "usuario": {
                "id": 1,
                "nome": "João Silva",
                "email": "joao.silva@empresa.com"
            },
            "sala": {
                "id": 1,
                "nome": "Sala de Reunião A",
                "capacidade": 10
            }
        }
    ]
}
```

---

## 🏗 Arquitetura e Decisões Técnicas

### Padrão Arquitetural

O projeto segue uma arquitetura em camadas com separação clara de responsabilidades:

1. **Controllers**: Apenas orquestram as chamadas, sem lógica de negócio
2. **Services**: Contêm toda a lógica de negócio e regras complexas
3. **Form Requests**: Centralizam a validação de dados de entrada
4. **Models**: Representam as entidades e relacionamentos
5. **Exceptions**: Exceções customizadas para casos específicos

### Por que não usar Filas/Jobs?

**Decisão**: Não utilizamos filas ou jobs neste projeto.

**Justificativa**:
- As operações são **síncronas** e requerem resposta imediata
- A verificação de conflito de horário precisa ser **instantânea** para o usuário
- Não há processamento pesado ou assíncrono necessário
- Não há necessidade de notificações ou e-mails em background
- A criação de reserva é uma operação simples e rápida

Se no futuro houver necessidade de:
- Envio de e-mails de confirmação
- Notificações push
- Processamento de relatórios pesados
- Integração com sistemas externos

Então seria apropriado implementar filas e jobs.

### Validação de Conflitos de Horário

A lógica de verificação de conflitos está implementada no `ReservaService` e verifica 4 casos de sobreposição:

1. **Nova reserva começa durante uma reserva existente**
2. **Nova reserva termina durante uma reserva existente**
3. **Nova reserva engloba completamente uma reserva existente**
4. **Reserva existente engloba completamente a nova reserva**

### Tratamento de Erros

- **Exceptions customizadas**: `ConflitoHorarioException` para conflitos de horário (HTTP 409)
- **Logs estruturados**: Todas as operações importantes são logadas
- **Respostas padronizadas**: Todas as respostas seguem o formato:
  ```json
  {
      "status": "success|error",
      "message": "Mensagem descritiva",
      "data": {}
  }
  ```

### Transações de Banco de Dados

As operações críticas (criação e atualização de reservas) utilizam transações para garantir consistência:

```php
DB::beginTransaction();
try {
    // Operações
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

---

## ⚠️ Tratamento de Erros

### Códigos HTTP Utilizados

- **200**: Sucesso
- **201**: Criado com sucesso
- **400**: Erro de validação ou requisição inválida
- **404**: Recurso não encontrado
- **409**: Conflito (ex: horário já reservado)
- **500**: Erro interno do servidor

### Exemplo de Erro de Validação

**Request:**
```bash
POST /api/reservas
Content-Type: application/json

{
    "usuario_id": 999,
    "sala_id": 1,
    "data_reserva": "2025-12-29",
    "horario_inicio": "15:00",
    "horario_fim": "14:00"
}
```

**Response (400):**
```json
{
    "message": "O horário de término deve ser posterior ao horário de início. (and 1 more error)",
    "errors": {
        "horario_fim": [
            "O horário de término deve ser posterior ao horário de início."
        ],
        "usuario_id": [
            "O usuário informado não existe."
        ]
    }
}
```

---

## 📝 Notas Importantes

1. **Formato de Data e Hora**:
   - Data: `YYYY-MM-DD` (ex: `2025-12-29`)
   - Hora: `HH:mm` (ex: `14:00`)

2. **Validações**:
   - A data da reserva não pode ser anterior a hoje
   - O horário de término deve ser posterior ao horário de início
   - Não é possível criar reservas com conflito de horário

3. **Índices do Banco de Dados**:
   - Foi criado um índice composto `(sala_id, data_reserva)` na tabela `reservas` para otimizar as consultas de verificação de conflito

---

## 👨‍💻 Desenvolvido por

Sistema desenvolvido como parte de um teste de programação, seguindo boas práticas de desenvolvimento Laravel e arquitetura de software.

---

## 📄 Licença

Este projeto é open-source e está disponível sob a licença MIT.
