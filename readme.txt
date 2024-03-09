=== PageSpeed Module ===
Contributors: kaggdesign
Donate link: https://kagg.eu/en/
Tags: PageSpeed Module, mod_pagespeed, Apache, Nginx, cache
Requires at least: 5.0
Tested up to: 6.3
Requires PHP: 7.0
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

PageSpeed Module plugin supports WordPress installation under Apache or Nginx with PageSpeed Module.

== Description ==

PageSpeed Module is an open-source module for Apache and Nginx created by Google to help Make the Web Faster by rewriting web pages to reduce latency and bandwidth.

The plugin allows purge caches created by Apache or Nginx Module and turn on development mode for WordPress site, bypassing PageSpeed cache.

The plugin requires PageSpeed Module to be installed with your Apache or Nginx web server. If PageSpeed Module is not installed, the plugin does nothing.

== Installation ==

= Minimum Requirements =

* PHP version 7.0 or greater (PHP 8.0 or greater is recommended)
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

= 2.1.0 =
* The minimum required WordPress version is now 5.0.

= 2.0.1 =
* Fixed PHP warning when the plugin has no settings saved.
* Fixed deprecation message with PHP 8.

= 2.0 =
* Tested with WordPress 6.3.
* Dropped support of PHP 5.6. The minimum required PHP version is 7.0 now.

= 1.5 =
* Tested with WordPress 6.0.

= 1.4 =
* Tested with WordPress 5.7.

= 1.3.1 =
* Fixed bug with REST requests in Development mode.

= 1.3 =
* Tested with WordPress 5.6.
* Admin scripts and styles are launched on the plugin settings page only.

= 1.2 =
* Tested with WordPress 5.5.

= 1.1.6 =
* Tested with WordPress 5.4.

= 1.1.5 =
* Tested with WordPress 5.2
* Minimal php version bumped up to 5.6

= 1.1.4 =
* Fixed bug with some Apache servers.
* Tested with WordPress 5.2.

= 1.1.3 =
* Tested with WordPress 5.1.

= 1.1.2 =
* Tested with WordPress 5.0.

= 1.1.1 =
* Fixed format of PURGE request for Cloudflare.

= 1.1 =
* Added detection if PageSpeed Module is installed on server.
* Added Cloudflare support.
* Added settings link on plugin page.

= 1.0.1 =
* Translation update.

= 1.0 =
* Initial release.
