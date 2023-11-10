# AdeowebSyliusLupaSearchPlugin

## Compatibility

The plugin is compatible with Sylius 1.11 and 1.12.

| Plugin version | Sylius | PHP |
|----------------|--------|-----|
| v1             | 1.11.* | 8.1 |
| v2             | 1.12.* | 8.3 |

## Installation

To install the AdeowebSyliusLupaSearchPlugin, follow these steps:

1. Install the bundle using Composer:

    ```bash
    composer require adeoweb/sylius-lupasearch-plugin
    ```

2. Open your `bundles.php` file located in the `config` directory of your Sylius project.

3. Add the following lines at the end of the file:

    ```php
    // config/bundles.php

    return [
        // ... other bundles ...

        Adeoweb\SyliusLupaSearchPlugin\AdeowebSyliusLupaSearchPlugin::class => ['all' => true],
    ];
    ```

4. Clear your cache:

    ```bash
    php bin/console cache:clear
    ```

## Configuration

To start using the AdeowebSyliusLupaSearchPlugin, you need to configure it first.

Create a file named `adeoweb_sylius_lupa_search.yaml` in the `config/packages` directory of your Sylius project with the following content:
```yaml
adeoweb_sylius_lupa_search:
    email: '%env(LUPA_SEARCH_EMAIL)%'
    password: '%env(LUPA_SEARCH_PASSWORD)%'
    index_id: '%env(LUPA_SEARCH_INDEX_ID)%'
    search_query_id: '%env(LUPA_SEARCH_SEARCH_QUERY_ID)%'
    export:
        batch_size_fetch_from_database: '%env(int:LUPA_SEARCH_BATCH_SIZE_FETCH_FROM_DATABASE)%'
        batch_size_send: '%env(int:LUPA_SEARCH_BATCH_SIZE_SEND)%'
```

Also, you need to add the following environment variables to your `.env` file, the variables names may be different depending on your needs,
but it should be the same as in the `adeoweb_sylius_lupa_search.yaml` file.

## Usage

The AdeowebSyliusLupaSearchPlugin provides LupaSearch to Sylius projects. It offers several commands to synchronize your data with LupaSearch.

### Update Lupa Facets

The `adeoweb:lupa:facets:update` command is used to synchronize your facets with LupaSearch. This command fetches all attributes and options from your Sylius project and sends them to LupaSearch as facets.

To do this, use the following command in your terminal:

```bash
bin/console adeoweb:lupa:facets:update
```
This command could be hooked up on a cron job to ensure that your facets are always up-to-date with your Sylius project. For example, you could set up a cron job to run this command every midnight.

>❗ Please note that for this command to work, you need to have at least one facet in your search query.

### Export Lupa Documents

The `adeoweb:lupa:documents:export` command is used to export all enabled product variants as documents to LupaSearch. This command fetches all enabled product variants from your Sylius project and sends them to LupaSearch. To do this, use the following command in your terminal:

```bash
bin/console adeoweb:lupa:documents:export
```

This command could be run one time after a nightly import to your Sylius project to ensure that all your product variants are exported to LupaSearch.

>❗ Please note that when using CLI (for example, Sylius catalog import), you should set isQueueForExport() to false in LupaExportContext. This will ensure that the product variants would not be put in the queue for export to LupaSearch. Instead, a good practice is to run the `adeoweb:lupa:documents:export` command after the import is finished.

### Initiate Lupa Documents Export

The `adeoweb:lupa:documents:export:initiate` command is used to fetch all queued catalog from the database and puts respective variants to the message queue for export to Lupa.

To do this, use the following command in your terminal:
```bash
bin/console adeoweb:lupa:documents:export:initiate
```

This command could be run after you have made changes to your product variants in your Sylius project. Entities associated with product variants that are updated via requests, such as through the Sylius Admin Panel or the API, get synchronized with LupaSearch upon the completion of the KernelFinishRequest. This process is managed using the ProductVariantDispatcherSubscriber class. This command is only needed if catalog updates are made in CLI context (for example during nightly imports).

>❗ Please note that when using CLI (for example, Sylius catalog import), you should set isQueueForExport() to false in LupaExportContext. This will ensure that the product variants would not be put in the queue for export to LupaSearch. Instead, a good practice is to run the `adeoweb:lupa:documents:export` command after the import is finished.
