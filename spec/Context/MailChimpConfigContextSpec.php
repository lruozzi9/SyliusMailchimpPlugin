<?php

declare(strict_types=1);

namespace spec\Setono\SyliusMailChimpPlugin\Context;

use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Setono\SyliusMailChimpPlugin\Context\LocaleContextInterface;
use Setono\SyliusMailChimpPlugin\Context\MailChimpConfigContext;
use Setono\SyliusMailChimpPlugin\Entity\MailChimpConfigInterface;
use Setono\SyliusMailChimpPlugin\Entity\MailChimpListInterface;
use Setono\SyliusMailChimpPlugin\Repository\MailChimpConfigRepository;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class MailChimpConfigContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MailChimpConfigContext::class);
    }

    function let(
        MailChimpConfigRepository $mailChimpConfigRepository,
        RepositoryInterface $mailChimpListRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext,
        FactoryInterface $mailChimpConfigFactory,
        FactoryInterface $mailChimpListFactory,
        EntityManagerInterface $configEntityManager
    ): void {
        $this->beConstructedWith(
            $mailChimpConfigRepository,
            $mailChimpListRepository,
            $channelContext,
            $localeContext,
            $mailChimpConfigFactory,
            $mailChimpListFactory,
            $configEntityManager
        );
    }

    function it_gets_config(
        FactoryInterface $mailChimpConfigFactory,
        MailChimpConfigInterface $config,
        FactoryInterface $mailChimpListFactory,
        MailChimpListInterface $list,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        LocaleContextInterface $localeContext,
        LocaleInterface $locale
    ): void {
        $mailChimpConfigFactory->createNew()->willReturn($config);
        $mailChimpListFactory->createNew()->willReturn($list);
        $channelContext->getChannel()->willReturn($channel);
        $localeContext->getLocale()->willReturn($locale);

        $list->setConfig($config);
        $list->addChannel($channel);
        $list->addLocale($locale);

        $config->setCode('default');
        $config->addList($list);
        $config->getListForChannelAndLocale($channel, $locale)->willReturn($list);

        $this->getConfig()->shouldBeEqualTo($config);
    }
}
