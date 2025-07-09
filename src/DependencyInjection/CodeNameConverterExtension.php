<?php

namespace Cordon\CodeNameConverterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CodeNameConverterExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Charge le fichier services.yaml situé dans le même dossier
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../Resources/config'));
        $loader->load('services.yaml');
    }
}