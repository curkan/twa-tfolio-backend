<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use Illuminate\Foundation\AliasLoader;

trait AliasesLoaderTrait
{
    public function loadAliases(): void
    {
        // `$this->aliases` is declared on each Container's Main Service Provider
        foreach ($this->aliases ?? [] as $aliasKey => $aliasValue) {
            if (class_exists($aliasValue)) {
                $this->loadAlias($aliasKey, $aliasValue);
            }
        }
    }

    /**
     * @param string $aliasKey
     * @param string $aliasValue
     *
     * @return void
     */
    private function loadAlias(string $aliasKey, string $aliasValue): void
    {
        AliasLoader::getInstance()->alias($aliasKey, $aliasValue);
    }
}
