<?php

declare(strict_types=1);

namespace PHPStanRules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * Правило: запрет использования Illuminate\* в Domain и Application слоях
 *
 * Это архитектурное ограничение для DDD (Domain-Driven Design).
 * Domain и Application слои должны быть независимы от фреймворка.
 *
 * @implements Rule<Node\Stmt\Use_>
 */
class NoIlluminateInDomainAndApplicationRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Use_::class;
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $file = $scope->getFile();

        // Проверяем только файлы в Domain и Application слоях
        if (! preg_match('#/src/[^/]+/(Domain|Application)/#', $file, $matches)) {
            return [];
        }

        $layer = $matches[1];
        $errors = [];
        $forbidden = [
            'Illuminate\\',
            'Symfony\\Component\\HttpFoundation\\',
            'Symfony\\Component\\Console\\',
        ];

        foreach ($node->uses as $use) {
            $useName = $use->name->toString();

            foreach ($forbidden as $prefix) {
                // Проверяем use Illuminate\*
                if (str_starts_with($useName, $prefix)) {
                    $errors[] = RuleErrorBuilder::message(
                        sprintf(
                            'АРХИТЕКТУРНОЕ НАРУШЕНИЕ: %s слой не должен зависеть от Laravel фреймворка. '.
                            'Найдено: use %s в файле %s. '.
                            'Используйте интерфейсы и dependency injection вместо прямых зависимостей от Illuminate.',
                            $layer,
                            $useName,
                            basename($file)
                        )
                    )
                        ->identifier('architecture.illuminate.forbidden')
                        ->tip('Domain и Application слои должны быть независимы от фреймворка')
                        ->build();
                }
            }
        }

        return $errors;
    }
}
