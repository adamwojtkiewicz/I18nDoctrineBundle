<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\EventListener;

use Doctrine\Common\EventSubscriber;

/**
 * Doctrine Listener
 *
 * @author David ALLIX
 */
abstract class DoctrineListener implements EventSubscriber
{
    protected function hasTrait(\ReflectionClass $reflClass, string $traitName, bool $isRecursive = false): bool
    {
        if (in_array($traitName, $reflClass->getTraitNames())) {
            return true;
        }

        $parentClass = $reflClass->getParentClass();

        if ((false === $isRecursive) || (false === $parentClass)) {
            return false;
        }

        return $this->hasTrait($parentClass, $traitName, $isRecursive);
    }

}