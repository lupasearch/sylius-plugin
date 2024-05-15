<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\DependencyInjection;

use LupaSearch\SyliusLupaSearchPlugin\Commands\ExportLupaDocumentsCommand;
use LupaSearch\SyliusLupaSearchPlugin\Commands\InitiateLupaDocumentsExportCommand;
use LupaSearch\SyliusLupaSearchPlugin\Manager\Api\DocumentsApiManager;
use LupaSearch\SyliusLupaSearchPlugin\Manager\Api\SearchQueriesApiManager;
use LupaSearch\LupaClient;
use Sylius\Bundle\CoreBundle\DependencyInjection\PrependDoctrineMigrationsTrait;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class LupaSearchSyliusLupaSearchExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');

        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $this->registerResources(Configuration::NAME, $config['driver'], $config['resources'], $container);

        $lupaClientDefinition = $container->getDefinition(LupaClient::class);
        $lupaClientDefinition->addMethodCall('setEmail', [$config[Configuration::EMAIL]]);
        $lupaClientDefinition->addMethodCall('setPassword', [$config[Configuration::PASSWORD]]);

        $sendAllVariantsToLupaDefinition = $container->getDefinition(ExportLupaDocumentsCommand::class);
        $sendAllVariantsToLupaDefinition->setArgument(
            '$limit',
            $config[Configuration::EXPORT][Configuration::EXPORT_BATCH_SIZE_SEND],
        );

        $sendPartialVariantsToLupaDefinition = $container->getDefinition(InitiateLupaDocumentsExportCommand::class);
        $sendPartialVariantsToLupaDefinition->setArgument(
            '$limit',
            $config[Configuration::EXPORT][Configuration::EXPORT_BATCH_SIZE_FETCH_FROM_DATABASE],
        );

        $documentsApiManagerDefinition = $container->getDefinition(DocumentsApiManager::class);
        $documentsApiManagerDefinition->setArgument('$lupaIndexId', $config[Configuration::INDEX_ID]);

        $searchQueriesApiManagerDefinition = $container->getDefinition(SearchQueriesApiManager::class);
        $searchQueriesApiManagerDefinition->setArgument('$lupaIndexId', $config[Configuration::INDEX_ID]);
        $searchQueriesApiManagerDefinition->setArgument(
            '$lupaSearchQueryId',
            $config[Configuration::SEARCH_QUERY_ID],
        );
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependDoctrineMigrations($container);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/packages'));

        $loader->load('messenger.yaml');
    }

    protected function getMigrationsNamespace(): string
    {
        return 'LupaSearch\SyliusLupaSearchPlugin\Migrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@LupaSearchSyliusLupaSearchPlugin/Migrations';
    }

    /**
     * @return string[]
     */
    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return [
            'Sylius\Bundle\CoreBundle\Migrations',
        ];
    }
}
