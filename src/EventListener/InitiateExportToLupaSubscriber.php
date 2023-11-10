<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\EventListener;

use LupaSearch\SyliusLupaSearchPlugin\Factory\InitiateExportToLupaFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class InitiateExportToLupaSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $lupasearchLupaBusExport,
        private readonly InitiateExportToLupaFactoryInterface $initiateExportToLupaFactory,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::TERMINATE => ['onKernelTerminate'],
        ];
    }

    public function onKernelTerminate(TerminateEvent $event): void
    {
        $this->lupasearchLupaBusExport->dispatch($this->initiateExportToLupaFactory->createNew());
    }
}
