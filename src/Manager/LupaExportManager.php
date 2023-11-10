<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;

/**
 * @implements LupaExportManagerInterface<object>
 */
class LupaExportManager implements LupaExportManagerInterface
{
    /**
     * @param iterable<LupaExportManagerInterface<object>> $listeners
     */
    public function __construct(
        protected readonly iterable $listeners,
        private readonly LupaExportContextInterface $lupaContext,
    ) {
    }

    public function supports(object $object): bool
    {
        foreach ($this->listeners as $listener) {
            if ($listener instanceof self) {
                return false;
            }

            if ($listener->supports($object)) {
                return true;
            }
        }

        return false;
    }

    public function export(object $object): void
    {
        if (!$this->lupaContext->isQueueForExport()) {
            return;
        }

        foreach ($this->listeners as $listener) {
            if ($listener instanceof self) {
                continue;
            }

            if (!$listener->supports($object)) {
                continue;
            }

            $listener->export($object);
        }
    }

    public function delete(object $object): void
    {
        if (!$this->lupaContext->isQueueForExport()) {
            return;
        }

        foreach ($this->listeners as $listener) {
            if ($listener instanceof self) {
                continue;
            }

            if (!$listener->supports($object)) {
                continue;
            }

            $listener->delete($object);
        }
    }
}
