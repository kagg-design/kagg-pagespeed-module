#!/bin/sh

set -eu

php_binary=$(git config --get pagespeed.phpPath || echo php)
"$php_binary" "$(dirname "$0")/update-changelog.php" "$@"
