# LupaSearch Sylius plugin

The LupaSearch Sylius plugin seamlessly integrates your Sylius store with the LupaSearch SaaS platform. This plugin handles the synchronization of product data and search configuration, ensuring your store's search functionality is always up-to-date and optimized for performance.

## Compatibility

The plugin is compatible with Sylius 1.12.\* and 1.13.\*

## Installation

> **_NOTE:_** Before installation, please contact our support team at support@lupasearch.com to obtain the necessary credentials and onboarding information.

To install the LupaSearch plugin, follow these steps:

1. Install the bundle using Composer:

    ```bash
    composer require lupasearch/sylius-lupasearch-plugin
    ```

2. Open your `bundles.php` file located in the `config` directory of your Sylius project.

3. Add the following lines at the end of the file:

    ```php
    // config/bundles.php

    return [
        // ... other bundles ...

        LupaSearch\SyliusLupaSearchPlugin\LupaSearchSyliusLupaSearchPlugin::class => [
            "all" => true,
        ],
    ];
    ```

4. Update the schema:

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

5. Clear your cache:

    ```bash
    php bin/console cache:clear
    ```

## Configuration

To start using the LupaSearch, you need to configure it first.

### Environment variables

```
# LupaSearch environment variables
LUPASEARCH_USER_EMAIL=
LUPASEARCH_USER_PASSWORD=
LUPASEARCH_INDEX_ID=
LUPASEARCH_SEARCH_QUERY_ID=
LUPASEARCH_BATCH_SIZE_FETCH_FROM_DATABASE=100
LUPASEARCH_BATCH_SIZE_SEND=100
LUPASEARCH_MESSENGER_TRANSPORT_DSN=amqp://rabbitmquser:rabbitmqpass@rabbitmq:5672
```

### Configuration file

Create a file named `lupasearch_sylius_lupasearch.yaml` in the `config/packages` directory of your Sylius project with the following content:

```yaml
lupa_search_sylius_lupa_search:
    email: "%env(LUPASEARCH_USER_EMAIL)%"
    password: "%env(LUPASEARCH_USER_PASSWORD)%"
    index_id: "%env(LUPASEARCH_INDEX_ID)%"
    search_query_id: "%env(LUPASEARCH_SEARCH_QUERY_ID)%"
    export:
        batch_size_fetch_from_database: "%env(int:LUPASEARCH_BATCH_SIZE_FETCH_FROM_DATABASE)%"
        batch_size_send: "%env(int:LUPASEARCH_BATCH_SIZE_SEND)%"
```

Also, you need to add the following environment variables to your `.env` file, the variables names may be different depending on your needs,
but it should be the same as in the `lupasearch_sylius_lupasearch.yaml` file.

## Usage

This plugin provides LupaSearch service integration to Sylius projects. It offers several commands to synchronize your data with LupaSearch.

### Update Facets

The `lupasearch:facets:update` command is used to synchronize your facets with LupaSearch. This command fetches all attributes and options from your Sylius project and sends them to LupaSearch as facets.

To do this, use the following command in your terminal:

```bash
bin/console lupasearch:facets:update
```

This command could be hooked up on a cron job to ensure that your facets are always up-to-date with your Sylius project. For example, you could set up a cron job to run this command every midnight.

> ❗ Please note that for this command to work, you need to have at least one facet in your search query.

### Export Documents

The `lupasearch:documents:export` command is used to export all enabled product variants as documents to LupaSearch. This command fetches all enabled product variants from your Sylius project and sends them to LupaSearch. To do this, use the following command in your terminal:

```bash
bin/console lupasearch:documents:export
```

This command could be run one time after a nightly import to your Sylius project to ensure that all your product variants are exported to LupaSearch.

> ❗ Please note that when using CLI (for example, Sylius catalog import), you should set isQueueForExport() to false in LupaExportContext. This will ensure that the product variants would not be put in the queue for export to LupaSearch. Instead, a good practice is to run the `lupasearch:documents:export` command after the import is finished.

### Initiate Documents Export

The `lupasearch:documents:export:initiate` command is used to fetch all queued catalog from the database and puts respective variants to the message queue for export to Lupa.

To do this, use the following command in your terminal:

```bash
bin/console lupasearch:documents:export:initiate
```

This command could be run after you have made changes to your product variants in your Sylius project. Entities associated with product variants that are updated via requests, such as through the Sylius Admin Panel or the API, get synchronized with LupaSearch upon the completion of the KernelFinishRequest. This process is managed using the ProductVariantDispatcherSubscriber class. This command is only needed if catalog updates are made in CLI context (for example during nightly imports).

> ❗ Please note that when using CLI (for example, Sylius catalog import), you should set isQueueForExport() to false in LupaExportContext. This will ensure that the product variants would not be put in the queue for export to LupaSearch. Instead, a good practice is to run the `lupasearch:documents:export:initiate` command after the import is finished.

> ❗ Currently, plugin is limited to `naming_strategy: doctrine.orm.naming_strategy.underscore` setting in `config/packages/doctrine.yaml` configuration file to function properly.
