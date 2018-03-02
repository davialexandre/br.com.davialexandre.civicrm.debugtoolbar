<?php

namespace DaviAlexandre\DebugToolbar\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProfilerPass implements CompilerPassInterface {

  public function process(ContainerBuilder $container) {
    $definition = $this->getProfilerDefinition($container);

    if(!$definition) {
      return;
    }

    $taggedServices = $container->findTaggedServiceIds('debug_toolbar.data_collector');

    foreach ($taggedServices as $id => $tags) {
      $definition->addMethodCall('addDataCollector', array(
        new Reference($id)
      ));
    }
  }

  private function getProfilerDefinition(ContainerBuilder $container) {
    if (!$container->has('debug_toolbar.profiler')) {
      return null;
    }

    return $container->findDefinition('debug_toolbar.profiler');
  }

}
