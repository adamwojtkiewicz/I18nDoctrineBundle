<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ODM\EventListener;

use A2lix\I18nDoctrineBundle\EventListener\ControllerListener as BaseControllerListener;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

/**
 * Controller Listener
 *
 * @author David ALLIX
 */
class ControllerListener extends BaseControllerListener
{
    public function onKernelController(ControllerEvent $event): void
    {
        [$object, $method] = $event->getController();

        $className = ClassUtils::getClass($object);
        $reflectionClass = new \ReflectionClass($className);
        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($this->annotationReader->getMethodAnnotation($reflectionMethod, I18nDoctrine::class)) {
            $this->om->getFilterCollection()->disable('oneLocale');

        } else {
            $this->om->getFilterCollection()->enable('oneLocale')->setParameter('locale', $event->getRequest()->getLocale());
        }
    }

}