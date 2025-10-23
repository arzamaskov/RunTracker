# run-app

[![Build](https://github.com/arzamaskov/run-app/actions/workflows/ci.yml/badge.svg)](https://github.com/arzamaskov/run-app/actions)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](./LICENSE)
![Version](https://img.shields.io/badge/version-0.1.0-green.svg)

Приложение для учёта и анализа беговых тренировок.  
Monorepo: единый **Laravel** (API + UI).

## Быстрый старт

```bash
# Клонировать репозиторий
git clone git@github.com:arzamaskov/run-app.git
cd run-app

# Полная установка проекта (сборка, установка зависимостей, миграции)
make install

# Или запустить отдельные шаги
make build          # Собрать Docker образы
make up             # Запустить контейнеры
make composer-install
make npm-install
make key-generate
make migrate
```

Приложение будет доступно по адресу: **http://localhost**

## Структура проекта

```
.
├── docker/              # Docker конфигурация
│   ├── nginx/          # Конфиги Nginx
│   ├── php/            # Dockerfile и php.ini
│   └── mysql/          # Конфиги MySQL
├── app/                # Laravel приложение (Controllers, Models)
├── resources/          # Фронтенд (views, CSS, JS)
├── database/           # Миграции и сиды
├── public/             # Веб-корень (index.php, assets)
├── docker-compose.yml  # Docker Compose конфигурация
├── Makefile           # Команды для управления проектом
└── vite.config.js     # Конфигурация Vite
```

## Стек технологий

- **Backend**: [Laravel 12](https://laravel.com/)
- **Frontend**: Vite + Tailwind CSS v4
- **Database**: MySQL 8.4
- **Cache/Queue**: Redis 7.4
- **Web Server**: Nginx 1.28 Alpine
- **Mail**: Mailpit (для локальной отладки)
- **Node.js**: Node 22 Alpine (для сборки фронтенда)
- **Deploy**: Docker Compose

## Основные команды (Makefile)

### Управление контейнерами
```bash
make up              # Запустить все контейнеры
make down            # Остановить все контейнеры
make restart         # Перезапустить контейнеры
make ps              # Показать статус контейнеров
make logs            # Показать логи всех контейнеров
make shell           # Подключиться к контейнеру PHP
```

### Composer и зависимости
```bash
make composer-install           # Установить PHP зависимости
make composer-update           # Обновить PHP зависимости
make composer-require PKG="vendor/package"  # Установить пакет
```

### NPM и фронтенд
```bash
make npm-install     # Установить Node зависимости
make npm-dev         # Запустить Vite в dev режиме
make npm-build       # Собрать production версию
```

### Laravel Artisan
```bash
make migrate         # Запустить миграции
make migrate-fresh   # Пересоздать БД и миграции
make migrate-fresh-seed  # Пересоздать БД, миграции и сиды
make seed            # Запустить сидеры
make cache-clear     # Очистить все кеши
make tinker          # Запустить Tinker REPL
```

### База данных
```bash
make mysql           # Подключиться к MySQL консоли
make mysql-slow-log  # Показать slow query log
make backup-db       # Создать бэкап БД
make restore-db FILE=backup.sql.gz  # Восстановить БД
```

### Качество кода и тестирование
```bash
make lint            # Проверка стиля кода (Laravel Pint)
make lint-fix        # Автоматическое исправление стиля
make stan            # Статический анализ (PHPStan level 5)
make test            # Запустить тесты
make test-coverage   # Запустить тесты с покрытием
```

Полный список команд: `make help`

## Доступные сервисы

После запуска `make up` будут доступны:

- **Приложение**: http://localhost
- **Vite Dev Server**: http://localhost:5173
- **Mailpit** (почта): http://localhost:8025
- **MySQL**: localhost:3306 (db: run_app / user: laravel / pass: secret)
- **Redis**: localhost:6379

## Работа с базой данных

### Первый запуск
```bash
# База данных создается автоматически при старте контейнера
make up
make migrate
```

### Пересоздание БД
```bash
make migrate-fresh      # Удалить все таблицы и создать заново
make migrate-fresh-seed # То же + заполнить тестовыми данными
```

### Бэкап и восстановление
```bash
# Создать бэкап
make backup-db

# Восстановить из бэкапа
make restore-db FILE=./backups/backup_20250123_120000.sql.gz
```

## Vite и Hot Module Replacement

Vite настроен для работы в Docker. После запуска `make npm-dev` или `make up`:

- Vite сервер доступен на http://localhost:5173
- Hot Module Replacement работает автоматически
- Изменения в CSS/JS применяются без перезагрузки страницы

### Проблемы с HMR?

Если стили не загружаются:
1. Убедитесь, что контейнер `node` запущен: `make ps`
2. Проверьте логи: `make logs-node`
3. Перезапустите Vite: `docker compose restart node`

## Решение проблем

### Контейнеры не запускаются
```bash
make down
make build
make up
```

### Ошибки прав доступа
```bash
make permissions-fix
```

### Очистка всех кешей
```bash
make cache-clear
make optimize-clear
```

### Полная переустановка
```bash
make clean           # Удалит контейнеры и volumes (⚠️ удаляет БД!)
make install         # Установит всё заново
```

## Разработка

### Стандарты кода
- PHP 8.4
- PSR-12 стандарт
- Laravel стандарт
- Все комментарии и сообщения на русском языке

### Перед коммитом
```bash
make lint            # Проверка стиля кода (Laravel Pint)
make stan            # Статический анализ (PHPStan)
make test            # Запуск тестов
```

### Архитектурные правила
При работе с модульным монолитом (DDD) важно соблюдать границы слоёв:

- Domain: чистая бизнес-логика без зависимостей от фреймворка
- Application: использование только Domain слоя и интерфейсов
- Infrastructure: любые технические зависимости (Eloquent, Facades, и т.д.)
- UI: любые Laravel компоненты

**Запрещено:**
- `use Illuminate\*` в `app/*/Domain/*` и `app/*/Application/*`
- Прямая работа с БД в Domain и Application
- HTTP зависимости (Request, Response) в Domain и Application

**Проверяйте это при code review!** Файл `phpstan.neon` содержит подробное описание правил.

### Формат коммитов
```
<тип>: <описание>

Примеры:
feat: добавлен учёт пробежек
fix: исправлена ошибка в расчёте темпа
```

## Roadmap

- [ ] **Auth**: регистрация, логин, роли (user/coach/admin)
- [ ] **Users**: профиль пользователя, настройки
- [ ] **Runs**: учёт пробежек, импорт из Garmin/Strava
- [ ] **Training Plans**: планы тренировок, календарь
- [ ] **Dashboard**: графики прогресса, статистика нагрузок
- [ ] **Notifications**: email уведомления
- [ ] **Integrations**: Strava, Garmin Connect
- [ ] **CI/CD**: GitHub Actions, автоматические тесты

## Дополнительная информация

### Архитектура

**Модульный монолит с DDD (Domain-Driven Design)**

**Bounded Contexts:**
- **Identity** — управление пользователями, аутентификация, роли
- **Invitation** — система приглашений (тренер → атлет)
- **Training** — учёт тренировок, пробежек, анализ данных
- **Plan** — планы тренировок, календарь, программы
- **Notifications** — уведомления (email, push)
- **Import** — импорт данных из Garmin, Strava, файлов

**Слои (Clean Architecture):**
- **Domain** — доменная модель (Entities, Value Objects, Domain Events)
- **Application** — бизнес-логика (UseCases/Actions, DTO, Commands, Queries)
- **Infrastructure** — технические детали (Eloquent Repositories, Mail, Files, Parsers, API клиенты)
- **UI** — пользовательский интерфейс (HTTP Controllers, Requests, Resources, Views)

**Принципы:**
- Monorepo: backend и frontend в одном репозитории
- RESTful API для возможного добавления мобильного приложения
- Docker-first разработка: всё работает в контейнерах
- Независимость модулей: минимум связей между Bounded Contexts
- Тестируемость: каждый слой покрывается тестами

### Производительность
- Redis для кеширования и очередей
- MySQL slow query log для отладки медленных запросов
- Vite для быстрой сборки фронтенда

### Безопасность
- Environment переменные для секретов
- MySQL с отдельным пользователем
- Nginx с оптимизированной конфигурацией

## Лицензия

MIT © 2025 Andrey Arzamaskov

---

**Полезные ссылки:**
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS v4](https://tailwindcss.com/docs)
- [Vite Guide](https://vitejs.dev/guide/)
- [Docker Compose](https://docs.docker.com/compose/)
