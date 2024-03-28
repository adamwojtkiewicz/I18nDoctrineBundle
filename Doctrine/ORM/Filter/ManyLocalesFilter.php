<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use A2lix\I18nDoctrineBundle\Doctrine\Interfaces\ManyLocalesInterface;

/**
 *
 * @author David ALLIX
 */
class ManyLocalesFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetaData $targetEntity, $targetTableAlias): string
    {
        // Check if the entity implements the right interface
        if (!$targetEntity->reflClass->implementsInterface(ManyLocalesInterface::class)) {
            return "";
        }

        return $targetTableAlias .'.locales LIKE %'. $this->getParameter('locale') .'%';
    }

}