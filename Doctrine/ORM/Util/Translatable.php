<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Translatable trait.
 *
 * Should be used inside entity, that needs to be translated.
 */
trait Translatable
{
    public function getTranslations(): Collection
    {
        return $this->translations = $this->translations ? : new ArrayCollection();
    }

    public function setTranslations(Collection $translations): self
    {
        $this->translations = $translations;
        return $this;
    }

    public function addTranslation($translation): self
    {
        $this->getTranslations()->set($translation->getLocale(), $translation);
        $translation->setTranslatable($this);
        return $this;
    }

    public function removeTranslation($translation): void
    {
        $this->getTranslations()->removeElement($translation);
    }

    public static function getTranslationEntityClass(): string
    {
        return __CLASS__ . 'Translation';
    }

    public function getCurrentTranslation()
    {
        return $this->getTranslations()->first();
    }

    public function __call($method, $args)
    {
        $method = (str_starts_with($method, 'get')) ? $method : 'get'. ucfirst($method);

        if (!$translation = $this->getCurrentTranslation()) {
            return null;
        }

        if (method_exists($translation, $method)) {
            return call_user_func([$translation, $method]);
        }
    }

}
