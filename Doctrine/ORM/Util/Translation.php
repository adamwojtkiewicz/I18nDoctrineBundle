<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translation trait.
 *
 * Should be used inside translation entity
 */
trait Translation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=10)
     */
    protected string $locale;
    protected $translatable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTranslatable()
    {
        return $this->translatable;
    }

    public function setTranslatable($translatable): self
    {
        $this->translatable = $translatable;
        return $this;
    }

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
