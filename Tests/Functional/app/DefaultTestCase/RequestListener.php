<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ThemeBundle\Tests\Functional\app\DefaultTestCase;

use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class RequestListener
{
    /**
     * @var ThemeRepositoryInterface
     */
    private $themeRepository;

    /**
     * @var ThemeContextInterface
     */
    private $themeContext;

    /**
     * @param ThemeRepositoryInterface $themeRepository
     * @param ThemeContextInterface $themeContext
     */
    public function __construct(ThemeRepositoryInterface $themeRepository, ThemeContextInterface $themeContext)
    {
        $this->themeRepository = $themeRepository;
        $this->themeContext = $themeContext;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            // don't do anything if it's not the master request
            return;
        }

        $this->themeContext->setTheme($this->themeRepository->findByLogicalName('sylius/first-test-theme'));
    }
}