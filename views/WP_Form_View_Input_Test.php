<?php

class WP_Form_View_Input_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('text');
		$input_view = new WP_Form_View_Input();
		//$select_view = new WP_Form_View_Select();

		$element->set_view($input_view);
		$this->assertNotEmpty($element->render());

		//$element->set_view($select_view);
		//$this->assertEmpty($element->render());
	}

	public function test_attribute_escaping() {
		$element = WP_Form_Element::create('text')
			->set_name('potato')
			->set_attribute('placeholder', "<html>in an attribute</html>")
			->set_attribute('size', 'this has "quotes"');
		$element->set_view(new WP_Form_View_Input());
		$output = $element->render();

		$this->assertTrue(strpos($output, esc_attr("<html>in an attribute</html>")) !== FALSE );
		$this->assertTrue(strpos($output, esc_attr('this has "quotes"')) !== FALSE );
	}

	public function test_text() {
		$element = WP_Form_Element::create('text')
			->set_name('potato')
			->add_class('pimiento')
			->set_attribute('placeholder', 'Enter your text');
		$element->set_view(new WP_Form_View_Input());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="text"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*name="potato"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="pimiento"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*placeholder="Enter your text"[^>]*/>$!', $output);
	}

	public function test_submit() {
		$element = WP_Form_Element::create('submit')
			->set_value('Submit Form')
			->add_class('potato');
		$element->set_view(new WP_Form_View_Input());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="submit"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*value="Submit Form"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="potato"[^>]*/>$!', $output);
	}

	public function test_hidden() {
		$element = WP_Form_Element::create('hidden')
			->set_name('potato')
			->add_class('pimiento');
		$element->set_view(new WP_Form_View_Input());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="hidden"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*name="potato"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="pimiento"[^>]*/>$!', $output);
	}
}
