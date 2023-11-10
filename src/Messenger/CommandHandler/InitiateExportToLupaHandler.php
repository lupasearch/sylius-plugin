<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Messenger\CommandHandler;

use LupaSearch\SyliusLupaSearchPlugin\Factory\ApplicationFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\InitiateExportToLupa;
use Exception;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class InitiateExportToLupaHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ApplicationFactoryInterface $applicationFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(InitiateExportToLupa $initiateExportToLupa): void
    {
        $application = $this->applicationFactory->createNew();
        $application->setAutoExit(false);

        $input = new ArrayInput(['command' => 'lupasearch:lupa:documents:export:initiate']);
        $output = new BufferedOutput();
        $application->run($input, $output);
    }
}
