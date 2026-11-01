<?php
/**
 * Dependency-free regression checks for changelog generation.
 *
 * @package kagg-pagespeed-module
 */

require dirname( __DIR__, 2 ) . '/.github/scripts/update-changelog.php';

$readme  = "== Changelog ==\n\n= 2.3.0 =\n* Release preparation.\n\n[See changelog for all versions](https://example.org/changelog.txt).\n\n== Upgrade Notice ==\nOther text.\n";
$history = "= 2.2.0 =\n* Previous release.\n\n= 2.0 =\n* Legacy release.\n";
$expect  = "= 2.3.0 =\n* Release preparation.\n\n" . $history;
$actual  = kagg_pagespeed_generate_changelog( $readme, $history );

if ( $expect !== $actual ) {
	throw new RuntimeException( 'Release notes or archived history changed unexpectedly.' );
}

if ( $expect !== kagg_pagespeed_generate_changelog( $readme, $actual ) ) {
	throw new RuntimeException( 'Generation must be idempotent.' );
}

if ( $expect !== kagg_pagespeed_generate_changelog( str_replace( "\n", "\r\n", $readme ), $history ) ) {
	throw new RuntimeException( 'Windows line endings must be supported.' );
}

$updated = str_replace( '* Release preparation.', '* Updated notes.', $readme );
if ( str_replace( '* Release preparation.', '* Updated notes.', $expect ) !== kagg_pagespeed_generate_changelog( $updated, $actual ) ) {
	throw new RuntimeException( 'The current release must be replaced without duplication.' );
}

foreach ( [ 'Missing section', "== Changelog ==\nNo release heading." ] as $invalid ) {
	try {
		kagg_pagespeed_generate_changelog( $invalid, $history );
	} catch ( RuntimeException $exception ) {
		continue;
	}
	throw new RuntimeException( 'Invalid release notes must be rejected.' );
}

echo "Changelog regression checks passed.\n";
