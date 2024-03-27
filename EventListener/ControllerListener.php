<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Controller Listener
 *
 * @author David ALLIX
 */
abstract class ControllerListener
{
    protected Reader $annotationReader;
    protected EntityManagerInterface $om;

    /**
     *
     * @param Reader $annotationReader
     * @param EntityManagerInterface $om
     */
    public function __construct(Reader $annotationReader, EntityManagerInterface $om)
    {
        $this->annotationReader = $annotationReader;
        $this->om = $om;
    }

}
