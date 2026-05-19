# Architecture Notes

## Stack

- PHP 8.2+, Symfony 7.4
- PostgreSQL 15 (Doctrine ORM)
- JWT auth (`firebase/php-jwt`)
- Docker: nginx + php-fpm + postgres (port 8080)
- API docs: NelmioApiDocBundle (Swagger UI at `/api/doc`)

## Layer Structure

```
src/
├── Application/        # Business logic (framework-free)
│   ├── Common/         # Shared interfaces: PasswordHasher, TokenGenerator, UuidGenerator
│   ├── ShortenUrl/     # URL shortening feature
│   │   ├── Domain/     # Entity, ValueObjects, Repository interface, Request/Response DTOs
│   │   ├── UseCase/    # CreateShortenUrlUseCase, GetOriginalUrlByAliasUseCase
│   │   ├── Action/     # GenerateUniqueAliasAction, GetShortenUrlAction
│   │   └── Assert/     # ShortenUrlNotExistsByAliasAssert
│   └── User/           # User feature (same structure)
├── Infrastructure/     # Framework/DB implementations
│   ├── Persistence/    # Doctrine entities, mappers, repositories
│   └── Security/       # JWT, BCrypt, UUID implementations
└── Presentation/       # HTTP layer
    ├── Controller/Api/ # AuthController, ShortenController, UserController
    ├── Controller/Web/ # RedirectController (alias → original URL)
    └── Http/           # CurrentUserValueResolver
```

## Key Concepts

**UseCase** — оркестрирует бизнес-логику, один публичный метод `run()`, `final readonly`.

**Action** — атомарная операция без оркестрации, один метод `run()`, `final readonly`.

**Domain entities** — чистые PHP-объекты (не Doctrine), маппятся через `ShortenUrlMapper`/`UserMapper`.

**Repository** — интерфейс в Application, реализация в Infrastructure. Маппер переводит Domain ↔ Doctrine entity.

## Dependency Rules (enforced via PHPat)

- `Application` не зависит от `Infrastructure` и `Presentation`
- `Domain` не зависит от `UseCase`, `Action`, `Infrastructure`, `Presentation`
- `UseCase` не вызывает другой `UseCase`
- `Action` не вызывает `UseCase`
- `Presentation` не использует Doctrine entities напрямую

## API Endpoints

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/auth/register` | — | Регистрация |
| POST | `/auth/login` | — | Логин, возвращает JWT |
| POST | `/shorten` | JWT | Создать короткую ссылку |
| GET | `/{alias}` | — | Редирект на оригинальный URL |

## Data Model

**User**: `id` (UUID), `email`, `password` (bcrypt)

**ShortenUrl**: `id`, `original_url`, `alias` (случайная строка), `user_id`, `created_at`, `expired_at` (TTL в секундах из запроса)

## Testing

- **Behat** — интеграционные тесты (`tests/Behat/Features/`)
- **PHPUnit + PHPat** — архитектурные тесты (`tests/Architecture/`)
- Отдельная БД для тестов (`db_test`, порт 5433)

## Code Quality

- PHPStan (уровень настроен в `phpstan.dist.neon`)
- PHP-CS-Fixer + PHP_CodeSniffer
- CI через GitHub Actions
