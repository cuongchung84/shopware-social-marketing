# Shopware Social Marketing Plugin

[![CI](https://github.com/your-username/shopware-social-marketing/actions/workflows/ci.yml/badge.svg)](https://github.com/your-username/shopware-social-marketing/actions/workflows/ci.yml)
[![Coverage Status](https://coveralls.io/repos/github/your-username/shopware-social-marketing/badge.svg?branch=main)](https://coveralls.io/github/your-username/shopware-social-marketing?branch=main)

SwagSocialMarketing is a Shopware 6.7 plugin that connects to Facebook, Instagram, and TikTok to post products for social marketing.

## Overview

This plugin allows you to connect your Shopware 6 store to your social media accounts (Facebook, Instagram, and TikTok) to automatically post products. You can post products manually from the product detail page in the admin area, or you can enable a scheduled task to post products automatically.

## Installation

### Manual Installation

1.  Download the latest release from the [releases page](https://github.com/your-username/shopware-social-marketing/releases).
2.  Unzip the release and upload the `SwagSocialMarketing` directory to the `custom/plugins` directory of your Shopware 6 installation.
3.  Install and activate the plugin in the Shopware 6 admin area.

### Composer Installation

1.  Run the following command in your Shopware 6 root directory:

    ```bash
    composer require your-username/shopware-social-marketing
    ```

2.  Install and activate the plugin in the Shopware 6 admin area.

## Configuration

1.  Go to `Settings > Extensions > Social Marketing`.
2.  Enter your API credentials for Facebook, Instagram, and TikTok.
3.  Set the schedule interval for automatic posting (in minutes).
4.  Enable the social networks you want to post to.

## Usage

### Manual Posting

1.  Go to `Catalogues > Products` and open a product.
2.  In the `Social Marketing` tab, click the `Post to Social Media` button.

### Scheduled Posting

1.  Enable the scheduled task in the plugin configuration.
2.  The plugin will automatically post products based on the configured schedule interval.

## Logging and Troubleshooting

The plugin logs all posting activities to a dedicated log file and to the database. You can view the logs in the Shopware 6 admin area under `Settings > Extensions > Social Marketing Log`.

If you encounter any issues, please check the logs for more information. You can also create an issue on the [GitHub repository](https://github.com/your-username/shopware-social-marketing/issues).
