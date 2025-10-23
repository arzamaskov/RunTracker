.PHONY: help build up down restart logs shell composer npm artisan migrate fresh seed test

# Цвета для вывода
GREEN  := \033[0;32m
YELLOW := \033[0;33m
NC     := \033[0m

# Пользователь для выполнения команд в контейнере
# По умолчанию используется пользователь laravel (uid:1000, gid:1000)
# Можно переопределить: make composer-install USER_ID=$(id -u)
USER_ID ?= 1000
GROUP_ID ?= 1000
EXEC_USER := -u $(USER_ID):$(GROUP_ID)

# Docker Compose команды
# Используем docker compose (v2) вместо docker-compose (v1)
DC := docker compose
DC_EXEC := $(DC) exec $(EXEC_USER)
DC_EXEC_ROOT := $(DC) exec -u root

help: ## Показать эту справку
	@echo "$(GREEN)Доступные команды:$(NC)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(YELLOW)%-15s$(NC) %s\n", $$1, $$2}'

build: ## Собрать Docker образы
	$(DC) build --no-cache

up: ## Запустить все контейнеры
	$(DC) up -d

down: ## Остановить все контейнеры
	$(DC) down

restart: ## Перезапустить все контейнеры
	$(DC) restart

logs: ## Показать логи всех контейнеров
	$(DC) logs -f

logs-nginx: ## Показать логи Nginx
	$(DC) logs -f nginx

logs-php: ## Показать логи PHP
	$(DC) logs -f php

logs-mysql: ## Показать логи MySQL
	$(DC) logs -f mysql

shell: ## Подключиться к контейнеру PHP (от пользователя laravel)
	$(DC_EXEC) php sh

shell-root: ## Подключиться к контейнеру PHP от root
	$(DC_EXEC_ROOT) php sh

mysql: ## Подключиться к MySQL консоли
	$(DC) exec mysql mysql -uroot -p

mysql-slow-log: ## Показать slow query log (последние 100 строк)
	@echo "$(GREEN)Slow query log (последние 100 строк):$(NC)"
	@$(DC) exec mysql tail -100 /var/log/mysql/slow-query.log || echo "Лог пуст или не настроен"

mysql-slow-analyze: ## Анализ медленных запросов (топ 10)
	@echo "$(GREEN)Топ 10 самых медленных запросов:$(NC)"
	@$(DC) exec mysql mysqldumpslow -s t -t 10 /var/log/mysql/slow-query.log 2>/dev/null || echo "Нет данных или mysqldumpslow не установлен"

mysql-slow-clear: ## Очистить slow query log
	@echo "$(YELLOW)⚠️  Очистка slow query log...$(NC)"
	@$(DC) exec mysql mysql -u root -p$(DB_ROOT_PASSWORD:-root) -e "FLUSH SLOW LOGS;" 2>/dev/null || true
	@$(DC) exec mysql sh -c "truncate -s 0 /var/log/mysql/slow-query.log 2>/dev/null" || true
	@echo "$(GREEN)✅ Лог очищен$(NC)"

redis-cli: ## Подключиться к Redis консоли
	$(DC) exec redis redis-cli

composer: ## Выполнить Composer команду (make composer CMD="install")
	$(DC_EXEC) php composer $(CMD)

composer-install: ## Установить PHP зависимости
	$(DC_EXEC) php composer install

composer-update: ## Обновить PHP зависимости
	$(DC_EXEC) php composer update

composer-require: ## Установить пакет (make composer-require PKG="vendor/package")
	$(DC_EXEC) php composer require $(PKG)

composer-dump: ## Обновить autoload
	$(DC_EXEC) php composer dump-autoload

npm: ## Выполнить NPM команду (make npm CMD="install")
	$(DC) exec node npm $(CMD)

npm-install: ## Установить Node зависимости
	$(DC) exec node npm install

npm-dev: ## Запустить Vite в режиме разработки
	$(DC) exec node npm run dev

npm-build: ## Собрать production версию фронтенда
	$(DC) exec node npm run build

npm-watch: ## Запустить watch mode
	$(DC) exec node npm run watch

artisan: ## Выполнить Artisan команду (make artisan CMD="migrate")
	$(DC_EXEC) php php artisan $(CMD)

migrate: ## Запустить миграции
	$(DC_EXEC) php php artisan migrate

migrate-rollback: ## Откатить последнюю миграцию
	$(DC_EXEC) php php artisan migrate:rollback

migrate-fresh: ## Пересоздать базу данных и запустить миграции
	$(DC_EXEC) php php artisan migrate:fresh

migrate-fresh-seed: ## Пересоздать базу данных, запустить миграции и сидеры
	$(DC_EXEC) php php artisan migrate:fresh --seed

seed: ## Запустить сидеры
	$(DC_EXEC) php php artisan db:seed

test: ## Запустить тесты
	$(DC_EXEC) php php artisan test

test-coverage: ## Запустить тесты с покрытием
	$(DC_EXEC) php php artisan test --coverage

test-filter: ## Запустить конкретный тест (make test-filter FILTER="TestName")
	$(DC_EXEC) php php artisan test --filter=$(FILTER)

lint: ## Проверить код на соответствие стандартам (Laravel Pint)
	$(DC_EXEC) php ./vendor/bin/pint --test

lint-fix: ## Автоматически исправить стиль кода (Laravel Pint)
	$(DC_EXEC) php ./vendor/bin/pint

pint: lint ## Алиас для lint

pint-fix: lint-fix ## Алиас для lint-fix

phpcs: lint ## Алиас для lint (совместимость)

stan: ## Запустить статический анализ кода (PHPStan)
	$(DC_EXEC) php ./vendor/bin/phpstan analyse --memory-limit=2G

phpstan: stan ## Алиас для stan

cache-clear: ## Очистить все кеши
	$(DC_EXEC) php php artisan cache:clear
	$(DC_EXEC) php php artisan config:clear
	$(DC_EXEC) php php artisan route:clear
	$(DC_EXEC) php php artisan view:clear

optimize: ## Оптимизировать приложение
	$(DC_EXEC) php php artisan config:cache
	$(DC_EXEC) php php artisan route:cache
	$(DC_EXEC) php php artisan view:cache

optimize-clear: ## Очистить оптимизацию
	$(DC_EXEC) php php artisan optimize:clear

key-generate: ## Сгенерировать ключ приложения
	$(DC_EXEC) php php artisan key:generate

storage-link: ## Создать симлинк для storage
	$(DC_EXEC) php php artisan storage:link

queue-work: ## Запустить обработку очередей
	$(DC_EXEC) php php artisan queue:work

queue-listen: ## Запустить прослушивание очередей
	$(DC_EXEC) php php artisan queue:listen

queue-restart: ## Перезапустить queue workers
	$(DC_EXEC) php php artisan queue:restart

tinker: ## Запустить Tinker REPL
	$(DC_EXEC) php php artisan tinker

permissions: ## Установить права доступа (выполняется от root)
	$(DC_EXEC_ROOT) php chown -R $(USER_ID):$(GROUP_ID) /var/www/html
	$(DC_EXEC_ROOT) php chmod -R 755 /var/www/html/storage
	$(DC_EXEC_ROOT) php chmod -R 755 /var/www/html/bootstrap/cache

permissions-fix: ## Исправить права доступа для storage и cache
	$(DC_EXEC_ROOT) php chown -R $(USER_ID):$(GROUP_ID) /var/www/html/storage /var/www/html/bootstrap/cache
	$(DC_EXEC_ROOT) php chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

install: build up composer-install npm-install key-generate migrate storage-link permissions ## Полная установка проекта

fresh-install: build up composer-install npm-install key-generate migrate-fresh-seed storage-link permissions ## Полная установка с пересозданием БД

clean: down ## ⚠️  Удалить все контейнеры и volumes (УДАЛЯЕТ БД!)
	@echo "$(YELLOW)⚠️  ВНИМАНИЕ: Эта команда удалит ВСЕ ДАННЫЕ включая БД!$(NC)"
	@echo "$(YELLOW)Нажмите Ctrl+C для отмены или Enter для продолжения...$(NC)"
	@read confirm
	$(DC) down -v
	docker system prune -f

clean-all: ## ⚠️  Удалить всё включая образы (УДАЛЯЕТ БД!)
	@echo "$(YELLOW)⚠️  ВНИМАНИЕ: Эта команда удалит ВСЕ ДАННЫЕ включая БД и образы!$(NC)"
	@echo "$(YELLOW)Нажмите Ctrl+C для отмены или Enter для продолжения...$(NC)"
	@read confirm
	$(DC) down -v --rmi all
	docker system prune -af

backup-db: ## Создать бэкап базы данных
	@mkdir -p ./backups
	@echo "$(GREEN)Создание бэкапа БД...$(NC)"
	$(DC) exec -T mysql mysqldump -u root -p$(DB_ROOT_PASSWORD:-root) $(DB_DATABASE:-l42k) | gzip > ./backups/backup_$(shell date +%Y%m%d_%H%M%S).sql.gz
	@echo "$(GREEN)✅ Бэкап создан в ./backups/$(NC)"

restore-db: ## Восстановить БД из бэкапа (make restore-db FILE=backup.sql.gz)
	@if [ -z "$(FILE)" ]; then \
		echo "$(YELLOW)⚠️  Укажите файл: make restore-db FILE=backup.sql.gz$(NC)"; \
		exit 1; \
	fi
	@echo "$(YELLOW)⚠️  ВНИМАНИЕ: Текущие данные БД будут заменены!$(NC)"
	@echo "$(YELLOW)Нажмите Ctrl+C для отмены или Enter для продолжения...$(NC)"
	@read confirm
	@echo "$(GREEN)Восстановление БД из $(FILE)...$(NC)"
	@gunzip < $(FILE) | $(DC) exec -T mysql mysql -u root -p$(DB_ROOT_PASSWORD:-root) $(DB_DATABASE:-l42k)
	@echo "$(GREEN)✅ БД восстановлена$(NC)"

volumes: ## Показать информацию о volumes
	@echo "$(GREEN)Docker volumes проекта:$(NC)"
	@docker volume ls | grep l42k || echo "Volumes не найдены"
	@echo ""
	@echo "$(GREEN)Размер volumes:$(NC)"
	@docker system df -v | grep l42k || echo "Volumes не найдены"

ps: ## Показать статус контейнеров
	$(DC) ps

ps-all: ## Показать все контейнеры Docker
	docker ps -a

stats: ## Показать статистику использования ресурсов
	docker stats

info: ## Показать информацию о проекте
	@echo "$(GREEN)Информация о проекте:$(NC)"
	@echo "  USER_ID:  $(USER_ID)"
	@echo "  GROUP_ID: $(GROUP_ID)"
	@echo ""
	@echo "$(GREEN)Версии:$(NC)"
	@$(DC_EXEC) php php -v | head -n 1
	@$(DC_EXEC) php composer --version
	@$(DC) exec node node -v
	@$(DC) exec node npm -v
	@echo ""
	@echo "$(GREEN)Laravel:$(NC)"
	@$(DC_EXEC) php php artisan --version

