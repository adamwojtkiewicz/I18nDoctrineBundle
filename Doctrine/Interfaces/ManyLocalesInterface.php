<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\Interfaces;

/**
 *
 * @author David ALLIX
 */
interface ManyLocalesInterface
{
    public function getLocales(): array;

    public function setLocales(array $locales): self;
}