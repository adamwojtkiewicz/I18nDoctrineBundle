<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ODM\Filter;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Query\Filter\BsonFilter;

class ManyLocalesFilter extends BsonFilter
{
    public function addFilterCriteria(ClassMetadata $targetMetadata)
    {

    }

}