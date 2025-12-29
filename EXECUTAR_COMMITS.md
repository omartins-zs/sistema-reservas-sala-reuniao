# Comandos de Commit — Sistema de Reservas de Salas

Este arquivo contém todos os comandos de commit prontos para execução, organizados na ordem sugerida.

## ⚠️ IMPORTANTE
Execute os commits na ordem apresentada abaixo para manter a consistência do histórico.

---

## 📚 Documentação

### 1. Atualizar README
```bash
git add README.md
git commit -m "📚 Atualizando documentação do README"
```

### 2. Adicionar Collection do Postman
```bash
git add Sistema_Reservas_Salas.postman_collection.json
git commit -m "📚 Adicionando collection do Postman"
```

---

## 🔧 Configuração

### 3. Configurar rotas da API no bootstrap
```bash
git add bootstrap/app.php
git commit -m "🔧 Configurando rotas da API no bootstrap"
```

### 4. Configurar rotas da API
```bash
git add routes/api.php
git commit -m "🔧 Configurando rotas da API"
```

### 5. Atualizar DatabaseSeeder
```bash
git add database/seeders/DatabaseSeeder.php
git commit -m "🔧 Atualizando DatabaseSeeder"
```

---

## 🗃️ Migrations

### 6. Criar migration de usuarios
```bash
git add database/migrations/2025_12_28_150719_create_usuarios_table.php
git commit -m "🗃️ Criando migration de usuarios"
```

### 7. Criar migration de salas
```bash
git add database/migrations/2025_12_28_150721_create_salas_table.php
git commit -m "🗃️ Criando migration de salas"
```

### 8. Criar migration de reservas
```bash
git add database/migrations/2025_12_28_150722_create_reservas_table.php
git commit -m "🗃️ Criando migration de reservas"
```

---

## 🗃️ Models

### 9. Criar model Usuario
```bash
git add app/Models/Usuario.php
git commit -m "🗃️ Criando model Usuario"
```

### 10. Criar model Sala
```bash
git add app/Models/Sala.php
git commit -m "🗃️ Criando model Sala"
```

### 11. Criar model Reserva
```bash
git add app/Models/Reserva.php
git commit -m "🗃️ Criando model Reserva"
```

---

## ✨ Services

### 12. Criar service de reservas
```bash
git add app/Services/ReservaService.php
git commit -m "✨ Criando service de reservas"
```

### 13. Criar service de salas
```bash
git add app/Services/SalaService.php
git commit -m "✨ Criando service de salas"
```

### 14. Criar service de usuarios
```bash
git add app/Services/UsuarioService.php
git commit -m "✨ Criando service de usuarios"
```

---

## ✨ Form Requests

### 15. Criar request de criação de reserva
```bash
git add app/Http/Requests/StoreReservaRequest.php
git commit -m "✨ Criando request de criação de reserva"
```

### 16. Criar request de atualização de reserva
```bash
git add app/Http/Requests/UpdateReservaRequest.php
git commit -m "✨ Criando request de atualização de reserva"
```

### 17. Criar request de criação de sala
```bash
git add app/Http/Requests/StoreSalaRequest.php
git commit -m "✨ Criando request de criação de sala"
```

### 18. Criar request de atualização de sala
```bash
git add app/Http/Requests/UpdateSalaRequest.php
git commit -m "✨ Criando request de atualização de sala"
```

### 19. Criar request de criação de usuario
```bash
git add app/Http/Requests/StoreUsuarioRequest.php
git commit -m "✨ Criando request de criação de usuario"
```

### 20. Criar request de atualização de usuario
```bash
git add app/Http/Requests/UpdateUsuarioRequest.php
git commit -m "✨ Criando request de atualização de usuario"
```

---

## ✨ Controllers

### 21. Criar controller API de reservas
```bash
git add app/Http/Controllers/Api/ReservaController.php
git commit -m "✨ Criando controller API de reservas"
```

### 22. Criar controller API de salas
```bash
git add app/Http/Controllers/Api/SalaController.php
git commit -m "✨ Criando controller API de salas"
```

### 23. Criar controller API de usuarios
```bash
git add app/Http/Controllers/Api/UsuarioController.php
git commit -m "✨ Criando controller API de usuarios"
```

---

## 🥅 Exceptions

### 24. Criar exception de conflito de horário
```bash
git add app/Exceptions/ConflitoHorarioException.php
git commit -m "🥅 Criando exception de conflito de horário"
```

---

## 🔧 Seeders

### 25. Criar seeder de usuarios
```bash
git add database/seeders/UsuarioSeeder.php
git commit -m "🔧 Criando seeder de usuarios"
```

### 26. Criar seeder de salas
```bash
git add database/seeders/SalaSeeder.php
git commit -m "🔧 Criando seeder de salas"
```

### 27. Criar seeder de reservas
```bash
git add database/seeders/ReservaSeeder.php
git commit -m "🔧 Criando seeder de reservas"
```

---

## 🚀 Executar Todos os Commits de Uma Vez

Se preferir, você pode copiar e colar todos os comandos abaixo em um script bash:

```bash
# Documentação
git add README.md
git commit -m "📚 Atualizando documentação do README"

git add Sistema_Reservas_Salas.postman_collection.json
git commit -m "📚 Adicionando collection do Postman"

# Configuração
git add bootstrap/app.php
git commit -m "🔧 Configurando rotas da API no bootstrap"

git add routes/api.php
git commit -m "🔧 Configurando rotas da API"

git add database/seeders/DatabaseSeeder.php
git commit -m "🔧 Atualizando DatabaseSeeder"

# Migrations
git add database/migrations/2025_12_28_150719_create_usuarios_table.php
git commit -m "🗃️ Criando migration de usuarios"

git add database/migrations/2025_12_28_150721_create_salas_table.php
git commit -m "🗃️ Criando migration de salas"

git add database/migrations/2025_12_28_150722_create_reservas_table.php
git commit -m "🗃️ Criando migration de reservas"

# Models
git add app/Models/Usuario.php
git commit -m "🗃️ Criando model Usuario"

git add app/Models/Sala.php
git commit -m "🗃️ Criando model Sala"

git add app/Models/Reserva.php
git commit -m "🗃️ Criando model Reserva"

# Services
git add app/Services/ReservaService.php
git commit -m "✨ Criando service de reservas"

git add app/Services/SalaService.php
git commit -m "✨ Criando service de salas"

git add app/Services/UsuarioService.php
git commit -m "✨ Criando service de usuarios"

# Form Requests
git add app/Http/Requests/StoreReservaRequest.php
git commit -m "✨ Criando request de criação de reserva"

git add app/Http/Requests/UpdateReservaRequest.php
git commit -m "✨ Criando request de atualização de reserva"

git add app/Http/Requests/StoreSalaRequest.php
git commit -m "✨ Criando request de criação de sala"

git add app/Http/Requests/UpdateSalaRequest.php
git commit -m "✨ Criando request de atualização de sala"

git add app/Http/Requests/StoreUsuarioRequest.php
git commit -m "✨ Criando request de criação de usuario"

git add app/Http/Requests/UpdateUsuarioRequest.php
git commit -m "✨ Criando request de atualização de usuario"

# Controllers
git add app/Http/Controllers/Api/ReservaController.php
git commit -m "✨ Criando controller API de reservas"

git add app/Http/Controllers/Api/SalaController.php
git commit -m "✨ Criando controller API de salas"

git add app/Http/Controllers/Api/UsuarioController.php
git commit -m "✨ Criando controller API de usuarios"

# Exceptions
git add app/Exceptions/ConflitoHorarioException.php
git commit -m "🥅 Criando exception de conflito de horário"

# Seeders
git add database/seeders/UsuarioSeeder.php
git commit -m "🔧 Criando seeder de usuarios"

git add database/seeders/SalaSeeder.php
git commit -m "🔧 Criando seeder de salas"

git add database/seeders/ReservaSeeder.php
git commit -m "🔧 Criando seeder de reservas"
```

---

## 📊 Resumo

- **Total de commits:** 27
- **Arquivos modificados:** 3
- **Arquivos novos:** 24

---

## ✅ Verificação

Após executar todos os commits, verifique o histórico:

```bash
git log --oneline -27
```

Você deve ver os 27 commits listados acima.

