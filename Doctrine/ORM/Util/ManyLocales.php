<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * Many locales trait.
 */
trait ManyLocales
{
    /**
     * @ORM\Column(type="simple_array")
     */
    protected array $locales;

    public function getLocales(): array
    {
        return $this->locales;
    }

    public function setLocales(array $locales): self
    {
        $this->locales = $locales;
        return $this;
    }
}
