# StudioPress CLI

Download StudioPress themes with WP CLI.

Requires an active StudioPress account.

## Installation

Install the plugin by downloading the zip file or via WP CLI.

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

- This project is not endorsed or supported by StudioPress. Please report issues via this GitHub repo.
- Currently requires PHP with the CURL module.
