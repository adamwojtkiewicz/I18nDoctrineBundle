<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\EventListener;

use A2lix\I18nDoctrineBundle\EventListener\DoctrineListener as BaseDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Events;

/**
 * Doctrine ORM Listener
 *
 * KnpDoctrineBehaviors (https://github.com/KnpLabs/DoctrineBehaviors/) inspiration
 *
 * @author David ALLIX
 */
class DoctrineListener extends BaseDoctrineListener
{
    private string $translatableTrait;
    private string $translationTrait;
    private int $translationFetchMode;
    private bool $isRecursive;

    public function __construct(string $translatableTrait, string $translationTrait, int|string $translationFetchMode, bool $isRecursive)
    {
        $this->translatableTrait = $translatableTrait;
        $this->translationTrait = $translationTrait;
        $this->translationFetchMode = $this->convertFetchString($translationFetchMode);
        $this->isRecursive = $isRecursive;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if (null === $classMetadata->reflClass) {
            return;
        }

        // Translatable object?
        if ($this->hasTrait($classMetadata->reflClass, $this->translatableTrait, $this->isRecursive)
            && !$classMetadata->hasAssociation('translations')) {

            $classMetadata->mapOneToMany(array(
                'fieldName' => 'translations',
                'mappedBy' => 'translatable',
                'fetch' => $this->translationFetchMode,
                'indexBy' => 'locale',
                'cascade' => array('persist', 'merge', 'remove'),
                'targetEntity' => $classMetadata->name . 'Translation'
            ));
        }

        // Translation object?
        if ($this->hasTrait($classMetadata->reflClass, $this->translationTrait, $this->isRecursive)
            && !$classMetadata->hasAssociation('translatable')) {

            $classMetadata->mapManyToOne(array(
                'fieldName' => 'translatable',
                'inversedBy' => 'translations',
                'fetch' => $this->translationFetchMode,
                'joinColumns' => array(array(
                    'name' => 'translatable_id',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE'
                )),
                'targetEntity' => substr($classMetadata->name, 0, -11)
            ));

            // Unique constraint
            $name = $classMetadata->getTableName() .'_unique_translation';
            if (!$this->hasUniqueTranslationConstraint($classMetadata, $name)) {
                $classMetadata->setPrimaryTable(array(
                    'uniqueConstraints' => array(array(
                        'name' => $name,
                        'columns' => array('translatable_id', 'locale')
                    )),
                ));
            }
        }
    }


    protected function hasUniqueTranslationConstraint(ClassMetadata $classMetadata, string $name): bool
    {
        if (!isset($classMetadata->table['uniqueConstraints'])) {
            return false;
        }

        foreach ($classMetadata->table['uniqueConstraints'] as $constraintName => $constraint) {
            if ($name === $constraintName) {
                return true;
            }
        }

        return false;
    }

    private function convertFetchString(string|int $fetchMode): int
    {
        if (is_int($fetchMode)) {
            return $fetchMode;
        }

        return match ($fetchMode) {
            "EAGER" => ClassMetadataInfo::FETCH_EAGER,
            "EXTRA_LAZY" => ClassMetadataInfo::FETCH_EXTRA_LAZY,
            default => ClassMetadataInfo::FETCH_LAZY,
        };
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

}
