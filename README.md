# Magecrafts_WysiwygMedia module

upload media to magento from media gallery or wysiwyg and add video tag to wysiwyg content

### 1. Self-installation
```
bin/magento maintenance:enable

composer require magecrafts/:*

bin/magento module:enable Magecrafts_CustomerLocation
bin/magento setup:upgrade
bin/magento cache:enable

bin/magento setup:di:compile

bin/magento setup:static-content:deploy -f
bin/magento maintenance:disable
```

## Installation details

For information about a module installation in Magento 2, see [Enable or disable modules](https://devdocs.magento.com/guides/v2.4/install-gde/install/cli/install-cli-subcommands-enable.html).

## Extensibility
