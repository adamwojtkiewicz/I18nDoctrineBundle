<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * One locale trait.
 *
 * Should be used inside entity, that needs to be localized
 */
trait OneLocale
{
    /**
     * @ORM\Column(length=10)
     */
    protected string $locale;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

}
