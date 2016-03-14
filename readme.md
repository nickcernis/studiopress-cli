# StudioPress CLI

Install StudioPress themes with WP CLI.

Requires an active StudioPress account.

## Installation

Install the plugin by downloading the [zip file](https://github.com/nickcernis/studiopress-cli/archive/0.1.2.zip) or via WP CLI:

`wp plugin install https://github.com/nickcernis/studiopress-cli/archive/0.1.2.zip --force --activate`

## Commands

### List available themes

`wp sp-theme list`

(You'll only be able to download themes you've paid for.)

### Install a theme

Install Genesis using your StudioPress username and password:

`wp sp-theme install genesis --spuser=test@example.com --sppass=password`

Install and activate Genesis Sample:

`wp sp-theme install genesis-sample --spuser=test@example.com --sppass=password --activate`

## Notes

- This project is not endorsed or supported by StudioPress. Please [report issues](https://github.com/nickcernis/studiopress-cli/issues/new) via this GitHub repo.
- Currently requires PHP with the CURL module.
