<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Actions;

/**
 * Class: Action.
 *
 * @abstract
 */
abstract class Action
{
    protected string $ui;

    /**
     * @return string
     */
    public function getUI(): string
    {
        return $this->ui;
    }

    /**
     * @param string $interface
     * @return static
     */
    public function setUI(string $interface): static
    {
        $this->ui = $interface;

        return $this;
    }
}
