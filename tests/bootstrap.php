<?php
/**
 * PHPUnit bootstrap file
 *
 * Composer autoloader must be loaded before WP_PHPUNIT__DIR will be available.
 */

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

tests_add_filter(
	'muplugins_loaded',
	function () {
		// test set up, plugin activation, etc.
		require dirname( dirname( __FILE__ ) ) . '/show-kanren-posts/show-kanren-posts.php';
	}
);

// Start up the WP testing environment.
putenv( sprintf( 'WP_PHPUNIT__TESTS_CONFIG=%s/wp-config.php', __DIR__ ) );  // phpcs:disable WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_putenv
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
