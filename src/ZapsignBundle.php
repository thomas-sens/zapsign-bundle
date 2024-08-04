<?php
namespace ThomasSens\ZapsignBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ZapsignBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->scalarNode('api_url')->cannotBeEmpty()->defaultValue('https://sandbox.api.zapsign.com.br')->info('Endpoint for the Zapsign Server API')->example('https://sandbox.api.zapsign.com.br')->end()
            ->scalarNode('api_token')->cannotBeEmpty()->defaultValue('')->info('API Token of user with access to Zapsign server')->example('af0dae0f-94e4-4f0e-9415-85c8b085a7d34ffd7954-77ac-466f-de3c-ccfc41e9b4d3')->end()
            ->end();
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
        $this->recursiveSettingContainerParameters($builder, ['zapsign'], $config);
    }

    protected function recursiveSettingContainerParameters(&$container, array $pathArray, array $array)
    {
        foreach ($array AS $key => $value) {
            if (is_array($value)) {
                $pathArray[] = $key;
                $this->recursiveSettingContainerParameters($container, $pathArray, $value);
            } else {
                $container->setParameter(implode('.', $pathArray) . '.' . $key, $value);
            }
        }
    }

}