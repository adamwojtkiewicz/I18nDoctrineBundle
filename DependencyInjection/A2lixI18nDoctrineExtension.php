<?php

declare(strict_types=1);

namespace A2lix\I18nDoctrineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use A2lix\I18nDoctrineBundle\Doctrine\ODM\EventListener\DoctrineListener as OdmDoctrineListener;
use A2lix\I18nDoctrineBundle\Doctrine\ODM\EventListener\ControllerListener as OdmControllerListener;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\EventListener\DoctrineListener as OrmDoctrineListener;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\EventListener\ControllerListener as OrmControllerListener;

/**
 * @author David ALLIX
 */
class A2lixI18nDoctrineExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('a2lix_i18n_doctrine.manager_registry', $config['manager_registry']);

        $container->setParameter('a2lix_i18n_doctrine.translatableTrait', $config['translatableTrait']);
        $container->setParameter('a2lix_i18n_doctrine.translationTrait', $config['translationTrait']);
        $container->setParameter('a2lix_i18n_doctrine.translatableFetchMode', $config['translatableFetchMode']);
        $container->setParameter('a2lix_i18n_doctrine.translationFetchMode', $config['translationFetchMode']);
        $container->setParameter('a2lix_i18n_doctrine.isRecursive', $config['isRecursive']);

        // ORM
        if ('doctrine' === $config['manager_registry']) {
            $container->setAlias('a2lix_i18n_doctrine.object_manager', 'doctrine.orm.entity_manager');
            $container->setParameter('a2lix_i18n_doctrine.listener.controller.class', OrmControllerListener::class);
            $container->setParameter('a2lix_i18n_doctrine.listener.doctrine.class', OrmDoctrineListener::class);

            // ODM MongoDB
        } elseif ('doctrine_mongodb' === $config['manager_registry']) {
            $container->setAlias('a2lix_i18n_doctrine.object_manager', 'doctrine.odm.document_manager');
            $container->setParameter('a2lix_i18n_doctrine.listener.controller.class', OdmControllerListener::class);
            $container->setParameter('a2lix_i18n_doctrine.listener.doctrine.class', OdmDoctrineListener::class);
        }
    }

}
