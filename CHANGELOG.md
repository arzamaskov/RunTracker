# Changelog

Все значимые изменения в проекте документируются в этом файле.

Формат основан на [Keep a Changelog](https://keepachangelog.com/ru/1.0.0/).

## [Unreleased]

### Added
- Лендинг с секциями: hero, features, how it works, pricing, FAQ
- Иконки и манифесты приложения (favicon, apple-touch-icon, web-app-manifest)
- CI/CD pipeline на GitHub Actions (lint, static-analysis, tests)
- CD workflow для автоматического деплоя по тегам
- Настройка MySQL 8.4 для тестов в CI
- CODEOWNERS для автоматического назначения ревьюеров
- Шаблон Pull Request
- Команда `make ci` для локальной проверки перед push
- Настройка Pint (исключение служебных папок)
- Кастомное правило PHPStan для проверки DDD архитектуры
- CHANGELOG.md для ведения истории изменений

### Changed
- Обновлен PHP до версии 8.4
- Бейдж версии в README теперь берется из git тегов

