<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\Interfaces;

/**
 *
 * @author David ALLIX
 */
interface OneLocaleInterface
{
    public function getLocale(): string;

    public function setLocale(string $locale): self;
}