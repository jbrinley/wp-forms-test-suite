<?php

class WP_UnitTestCase_Test extends WP_UnitTestCase {

	public function testPluginsLoaded() {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
		$this->assertTrue(is_plugin_active('wp-forms/wp-forms.php'), 'WP Forms not loaded');
	}
}