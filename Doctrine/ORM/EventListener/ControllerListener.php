<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\Doctrine\ORM\EventListener;

use A2lix\I18nDoctrineBundle\EventListener\ControllerListener as BaseControllerListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Doctrine\Common\Util\ClassUtils;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;

/**
 * Controller Listener
 *
 * @author David ALLIX
 */
class ControllerListener extends BaseControllerListener
{
    /**
     * @throws \ReflectionException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        [$object, $method] = $event->getController();

        $className = ClassUtils::getClass($object);
        $reflectionClass = new \ReflectionClass($className);

        // Sonata
        $sonataAdmin = 'Sonata\AdminBundle\Controller\CRUDController';
        if (class_exists($sonataAdmin) && ($sonataAdmin === $className || $reflectionClass->isSubclassOf($sonataAdmin)) && in_array($method, ['createAction', 'editAction'])) {
            $this->om->getFilters()->disable('oneLocale');
            return;
        }

        $reflectionMethod = $reflectionClass->getMethod($method);
        if ($this->annotationReader->getMethodAnnotation($reflectionMethod, I18nDoctrine::class)) {
            $this->om->getFilters()->disable('oneLocale');

        } else {
            $this->om->getFilters()->enable('oneLocale')->setParameter('locale', $event->getRequest()->getLocale());
        }
    }

}
