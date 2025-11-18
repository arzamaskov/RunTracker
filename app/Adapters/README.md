# Директория с адаптерами модулей

```php
<?php

declare(strict_types=1);

namespace App\Adapters;

class XAdapter
{
    public function __construct(private readonly API $moduleXapi) {}

    public function getSomeData(): array
    {
        $this->moduleXapi->getSomeData();
        // маппинг данных - превращение внешних данных во внутреннее представление

        return []; // возвращаем преобразованные данные
    }
}
```
