<?php

namespace A2lix\I18nDoctrineBundle\EventListener;

use Doctrine\Common\Annotations\Reader,
    Doctrine\ORM\EntityManagerInterface;

/**
 * Controller Listener
 *
 * @author David ALLIX
 */
abstract class ControllerListener
{
    protected $annotationReader;
    protected $om;

    /**
     *
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     * @param \Doctrine\ORM\EntityManagerInterface $om
     */
    public function __construct(Reader $annotationReader, EntityManagerInterface $om)
    {
        $this->annotationReader = $annotationReader;
        $this->om = $om;
    }

}
