<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\SelectMenu;

trait HasDefaultValues
{
    protected array $defaultValues = [];

    public function setDefaultValues(array $defaultValues): self
    {
        $this->defaultValues = $defaultValues;

        return $this;
    }
}
