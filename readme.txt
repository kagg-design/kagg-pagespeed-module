=== PageSpeed Module ===
Contributors: kaggdesign
Donate link: https://kagg.eu/en/
Tags: PageSpeed Module, mod_pagespeed, Apache, Nginx, cache
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

PageSpeed Module plugin supports WordPress installation under Apache or Nginx with PageSpeed Module.

== Description ==

PageSpeed Module is an open-source module for Apache and Nginx created by Google to help Make the Web Faster by rewriting web pages to reduce latency and bandwidth.

The plugin allows purge caches created by Apache or Nginx Module and turn on development mode for WordPress site, bypassing PageSpeed cache.

The plugin requires PageSpeed Module to be installed with your Apache or Nginx web server. If PageSpeed Module is not installed, the plugin does nothing.

== Installation ==

= Minimum Requirements =

* PHP version 7.4 or greater (PHP 8.0 or greater is recommended)
* MySQL version 5.5 or greater (MySQL 5.6 or greater is recommended)
* PageSpeed Module for Apache or Nginx
* In Apache config, the following directives must present:
`ModPagespeedEnableCachePurge on`
`ModPagespeedPurgeMethod PURGE`
* In Nginx config, the following directives must present:
`pagespeed EnableCachePurge on;`
`pagespeed PurgeMethod PURGE;`

== Frequently Asked Questions ==

= Where can I get support or talk to other users? =

If you get stuck, you can ask for help in the [PageSpeed Module Plugin Forum](https://wordpress.org/support/plugin/pagespeed-module).

== Screenshots ==

1. The PageSpeed Module settings panel.

== Changelog ==

= 2.3.0 =
* Tested with WordPress 7.1.4.
* Updated development dependencies, release tooling, and CI checks.

[See changelog for all versions](https://github.com/kagg-design/kagg-pagespeed-module/blob/master/changelog.txt).
