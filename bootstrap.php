<?php

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array(
		'wp-forms/wp-forms.php',
	),
	'template' => 'twentytwelve',
	'stylesheet' => 'twentytwelve',
);

require_once(dirname(__FILE__).'/wordpress-tests/bootstrap.php');