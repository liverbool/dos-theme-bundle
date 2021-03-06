<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ThemeBundle\Asset;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ThemeBundle\Asset\PathResolver;
use Sylius\Bundle\ThemeBundle\Model\ThemeInterface;

/**
 * @mixin PathResolver
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class PathResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ThemeBundle\Asset\PathResolver');
    }

    function it_implements_path_resolver_interface()
    {
        $this->shouldImplement('Sylius\Bundle\ThemeBundle\Asset\PathResolverInterface');
    }

    function it_returns_modified_path_if_its_referencing_bundle_asset(ThemeInterface $theme)
    {
        $theme->getLogicalName()->shouldBeCalled()->willReturn("sylius/test-theme");

        $this->resolve('bundles/asset.min.js', $theme)->shouldReturn('bundles/_theme/sylius/test-theme/asset.min.js');
    }

    function it_does_not_change_path_if_its_not_referencing_bundle_asset(ThemeInterface $theme)
    {
        $this->resolve('/long.path/asset.min.js', $theme)->shouldReturn('/long.path/asset.min.js');
    }
}