<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemeBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class ThemeCompilerPass implements CompilerPassInterface
{
    /**
     * Adds serialized themes to theme repository.
     *
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('sylius.theme.repository');

        $loader = $container->get('sylius.theme.loader');

        $serializedThemes = [];
        try {
            $themeFiles = $container->get('sylius.theme.locator')->locate('theme.json', null, false);
            foreach ($themeFiles as $themeFile) {
                $serializedThemes[] = serialize($loader->load($themeFile));
                $container->addResource(new FileResource($themeFile));
            }

            $definition->addArgument($serializedThemes);
        } catch (\InvalidArgumentException $e) {
            // No files found.
        }
    }
}