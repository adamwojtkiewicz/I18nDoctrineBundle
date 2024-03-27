<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ODM\EventListener;

use A2lix\I18nDoctrineBundle\EventListener\DoctrineListener as BaseDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

class DoctrineListener extends BaseDoctrineListener
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if (null === $classMetadata->reflClass) {
            return;
        }

        if (!property_exists($this, 'translatableTrait') || !property_exists($this, 'isRecursive')) {
            return;
        }

        // Translatable object?
        if ($this->hasTrait($classMetadata->reflClass, $this->translatableTrait, $this->isRecursive) && !$classMetadata->hasAssociation('translations')) {


            $classMetadata->mapManyEmbedded([
                'fieldName' => 'translations',
                'targetDocument' => $classMetadata->name . 'Translation',
                'strategy' => 'pushAll',
            ]);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

}