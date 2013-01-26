<?php

class WP_Form_View_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('text');
		$text_view = new WP_Form_View_Text();
		$hidden_view = new WP_Form_View_Hidden();

		$element->set_view($text_view);
		$this->assertNotEmpty($element->render(TRUE));

		$element->set_view($hidden_view);
		$this->assertEmpty($element->render(TRUE));
	}
}
