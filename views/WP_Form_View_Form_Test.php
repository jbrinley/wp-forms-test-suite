<?php

class WP_Form_View_Form_Test extends WP_UnitTestCase {
	public function test_creation() {
		$view = new WP_Form_View_Form();
		$this->assertInstanceOf('WP_Form_View_Form', $view);
	}

	public function test_output() {
		$form = new WP_Form('test-form');
		$form->set_view(new WP_Form_View_Form());
		$output = $form->render();

		$this->assertRegExp('!^<form[^>]*action=""[^>]*>.*</form>$!', $output);
	}

	public function test_children() {
		$form = new WP_Form('test-form');
		$form->set_view(new WP_Form_View_Form());

		$child = WP_Form_Element::create('text')->set_name('potato');
		$child->set_view(new WP_Form_View_Text());

		$form->add_element($child);
		$output = $form->render();

		$this->assertRegExp('!^<form[^>]*action=""[^>]*>.*<input[^>]*name="potato"[^>]*/>.*</form>$!', $output);
	}
}
