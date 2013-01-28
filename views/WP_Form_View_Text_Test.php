<?php

class WP_Form_View_Text_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('text');
		$text_view = new WP_Form_View_Text();
		$hidden_view = new WP_Form_View_Hidden();

		$element->set_view($text_view);
		$this->assertNotEmpty($element->render(TRUE));

		$element->set_view($hidden_view);
		$this->assertEmpty($element->render(TRUE));
	}

	public function test_output() {
		$element = WP_Form_Element::create('text')
			->set_name('potato')
			->add_class('pimiento')
			->set_attribute('placeholder', 'Enter your text');
		$element->set_view(new WP_Form_View_Text());

		$output = $element->render();
		$this->assertRegExp('!^<input[^>]*type="text"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*name="potato"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*class="pimiento"[^>]*/>$!', $output);
		$this->assertRegExp('!^<input[^>]*placeholder="Enter your text"[^>]*/>$!', $output);
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
