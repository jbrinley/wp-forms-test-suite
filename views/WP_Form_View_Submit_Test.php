<?php

class WP_Form_View_Submit_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('submit');
		$text_view = new WP_Form_View_Text();
		$submit_view = new WP_Form_View_Submit();

		$element->set_view($text_view);
		$this->assertEmpty($element->render());

		$element->set_view($submit_view);
		$this->assertNotEmpty($element->render());
	}

	public function test_output() {
		$element = WP_Form_Element::create('submit')
			->set_value('Submit Form')
			->add_class('potato');
		$element->set_view(new WP_Form_View_Submit());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="submit"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*value="Submit Form"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="potato"[^>]*/>$!', $output);
	}

	public function test_attribute_escaping() {
		$element = WP_Form_Element::create('text')
			->set_name('potato')
			->set_attribute('placeholder', "<html>in an attribute</html>")
			->set_attribute('size', 'this has "quotes"');
		$element->set_view(new WP_Form_View_Text());
		$output = $element->render();

		$this->assertTrue(strpos($output, esc_attr("<html>in an attribute</html>")) !== FALSE );
		$this->assertTrue(strpos($output, esc_attr('this has "quotes"')) !== FALSE );
	}
}
