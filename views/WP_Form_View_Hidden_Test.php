<?php

class WP_Form_View_Hidden_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('hidden');
		$text_view = new WP_Form_View_Text();
		$hidden_view = new WP_Form_View_Hidden();

		$element->set_view($text_view);
		$this->assertEmpty($element->render(TRUE));

		$element->set_view($hidden_view);
		$this->assertNotEmpty($element->render(TRUE));
	}

	public function test_output() {
		$element = WP_Form_Element::create('hidden')
			->set_name('potato')
			->add_class('pimiento');
		$element->set_view(new WP_Form_View_Hidden());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="hidden"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*name="potato"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="pimiento"[^>]*/>$!', $output);
	}
}
