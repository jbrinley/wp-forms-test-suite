<?php

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array(
		'wp-forms/wp-forms.php',
	),
	'template' => 'twentytwelve',
	'stylesheet' => 'twentytwelve',
);

// If the wordpress-tests repo location has been customized (and specified
// with WP_TESTS_DIR), use that location. This will most commonly be the case
// when configured for use with Travis CI.

// Otherwise, we'll just assume that this plugin is installed in the WordPress
// SVN external checkout configured in the wordpress-tests repo.

if( false !== getenv( 'WP_TESTS_DIR' ) ) {
	require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';
} else {
	require dirname( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ) . '/includes/bootstrap.php';
}
