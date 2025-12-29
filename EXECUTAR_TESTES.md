# 🧪 Executar Testes com Pest 4

## Comando para executar todos os testes:

```bash
php artisan test
```

ou

```bash
./vendor/bin/pest
```

## Comandos específicos:

### Executar apenas testes Unit:
```bash
php artisan test --testsuite=Unit
```

### Executar apenas testes Feature:
```bash
php artisan test --testsuite=Feature
```

### Executar testes de um arquivo específico:
```bash
php artisan test tests/Unit/Services/ReservaServiceTest.php
```

### Executar testes com cobertura:
```bash
php artisan test --coverage
```

### Executar testes em modo paralelo (mais rápido):
```bash
php artisan test --parallel
```

## Estrutura de Testes Criada:

### ✅ Testes Unit (tests/Unit/)
- **Models/**
  - `UsuarioTest.php` - Testes de relacionamentos e atributos do modelo Usuario
  - `SalaTest.php` - Testes de relacionamentos e atributos do modelo Sala
  - `ReservaTest.php` - Testes de relacionamentos e atributos do modelo Reserva

- **Services/**
  - `ReservaServiceTest.php` - Testes de lógica de negócio de reservas
    - Verificação de conflitos de horário
    - Verificação de horário de funcionamento
    - Criação e atualização de reservas
  - `SalaServiceTest.php` - Testes de lógica de negócio de salas
  - `UsuarioServiceTest.php` - Testes de lógica de negócio de usuários

### ✅ Testes Feature (tests/Feature/)
- **Api/**
  - `UsuarioApiTest.php` - Testes de endpoints da API de usuários
  - `SalaApiTest.php` - Testes de endpoints da API de salas
  - `ReservaApiTest.php` - Testes de endpoints da API de reservas
    - Criação com validação de conflitos
    - Verificação de disponibilidade
    - Validação de horário de funcionamento

- **Web/**
  - `ReservaWebTest.php` - Testes de formulários web de reservas
  - `DashboardWebTest.php` - Testes da página dashboard

## Factories Criadas:

- `UsuarioFactory.php` - Factory para criar usuários de teste
- `SalaFactory.php` - Factory para criar salas de teste
- `ReservaFactory.php` - Factory para criar reservas de teste

## Total de Testes:

- **Unit Tests**: ~20 testes
- **Feature Tests**: ~30 testes
- **Total**: ~50 testes

## Exemplos de Testes Incluídos:

✅ Verificação de conflitos de horário
✅ Validação de horário de funcionamento das salas
✅ CRUD completo de Usuários, Salas e Reservas
✅ Validações de formulários
✅ Testes de relacionamentos entre modelos
✅ Testes de endpoints da API
✅ Testes de formulários web

