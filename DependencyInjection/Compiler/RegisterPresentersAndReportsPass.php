<?php

namespace Orkestra\Bundle\ReportBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Registers all properly tagged services as Reports or Presenters
 */
class RegisterPresentersAndReportsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('orkestra.report_factory')) {
            return;
        }

        $definition = $container->getDefinition('orkestra.report_factory');

        foreach ($container->findTaggedServiceIds('orkestra.report_presenter') as $serviceId => $tags) {
            $definition->addMethodCall('addPresenter', array(new Reference($serviceId)));
        }

        foreach ($container->findTaggedServiceIds('orkestra.report') as $serviceId => $tags) {
            $definition->addMethodCall('addReport', array(new Reference($serviceId)));
        }
    }
}
