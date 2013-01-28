<?php

class WP_Form_View_Test extends WP_UnitTestCase {
	public function test_creation() {
		$text_view = new WP_Form_View_Text();
		$this->assertInstanceOf('WP_Form_View_Text', $text_view);
	}
}
