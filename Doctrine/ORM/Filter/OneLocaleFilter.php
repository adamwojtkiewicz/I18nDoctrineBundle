<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface;

/**
 *
 * @author David ALLIX
 */
class OneLocaleFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetaData $targetEntity, $targetTableAlias): string
    {
        // Check if the entity implements the right interface
        if (!$targetEntity->reflClass->implementsInterface(OneLocaleInterface::class)) {
            return "";
        }

        return $targetTableAlias .'.locale = '. $this->getParameter('locale');
    }

}