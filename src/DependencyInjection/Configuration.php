<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\DependencyInjection;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIds;
use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const NAME = 'lupasearch_sylius_lupa_search';

    public const EMAIL = 'email';

    public const PASSWORD = 'password';

    public const INDEX_ID = 'index_id';

    public const SEARCH_QUERY_ID = 'search_query_id';

    public const EXPORT = 'export';

    public const EXPORT_BATCH_SIZE_FETCH_FROM_DATABASE = 'batch_size_fetch_from_database';

    public const EXPORT_BATCH_SIZE_SEND = 'batch_size_send';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::NAME);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->cannotBeEmpty()->end()
            ->end();

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode(self::EMAIL)->isRequired()->cannotBeEmpty()->end()
                ->scalarNode(self::PASSWORD)->isRequired()->cannotBeEmpty()->end()
                ->scalarNode(self::INDEX_ID)->isRequired()->cannotBeEmpty()->end()
                ->scalarNode(self::SEARCH_QUERY_ID)->isRequired()->cannotBeEmpty()->end()
                ->arrayNode(self::EXPORT)
                    ->children()
                        ->integerNode(self::EXPORT_BATCH_SIZE_FETCH_FROM_DATABASE)->isRequired()->defaultValue(100)->end()
                        ->integerNode(self::EXPORT_BATCH_SIZE_SEND)->isRequired()->defaultValue(100)->end()
                    ->end()
                ->end()
            ->end();

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('lupa_exportable_ids')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(LupaExportableIds::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(LupaExportableIdsInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(DefaultResourceType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
