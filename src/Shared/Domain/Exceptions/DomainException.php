<?php

declare(strict_types=1);

namespace RunTracker\Shared\Domain\Exceptions;

use DomainException as PhpDomainException;

/**
 * Базовое исключение для всех доменных ошибок приложения.
 *
 * Используйте это исключение как родительский класс для всех
 * исключений, которые представляют нарушение бизнес-правил домена.
 *
 * Отличие от технических исключений:
 * - DomainException - нарушение бизнес-правила (например, "Email уже занят")
 * - RuntimeException - техническая проблема (например, "БД недоступна")
 */
abstract class DomainException extends PhpDomainException {}
