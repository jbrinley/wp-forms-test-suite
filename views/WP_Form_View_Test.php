<?php

class WP_Form_View_Test extends WP_UnitTestCase {
	public function test_creation() {
		$text_view = new WP_Form_View_Input();
		$this->assertInstanceOf('WP_Form_View_Input', $text_view);
	}
}
