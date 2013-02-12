<?php

class WP_Form_View_WPEditor_Test extends WP_UnitTestCase {

	public function test_content() {
		// enable rich editing
		global $wp_rich_edit;
		$wp_rich_edit = TRUE;

		$element = WP_Form_Element::create('textarea')->set_name('green');
		$element->set_value('Textarea content');
		$editor = new WP_Form_View_WPEditor();
		$element->set_view($editor);

		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'textarea',
				'content' => 'Textarea content',
				'attributes' => array(
					'name' => 'green',
					'rows' => 5,
				),
			),
			$output
		);
		$this->assertTag(
			array(
				'tag' => 'div',
				'class' => 'wp-editor-container',
			),
			$output
		);

		$this->assertTag(
			array(
				'class' => 'wp-switch-editor',
			),
			$output
		);
	}

	public function test_settings() {
		// enable rich editing
		global $wp_rich_edit;
		$wp_rich_edit = TRUE;

		$element = WP_Form_Element::create('textarea')->set_name('green');
		$element->set_value('Textarea content');
		$editor = new WP_Form_View_WPEditor();
		$editor->setting('tinymce', FALSE);
		$editor->setting('media_buttons', FALSE);
		$element->set_view($editor);

		$output = $element->render();

		$this->assertNotTag(
			array(
				'class' => 'wp-switch-editor',
			),
			$output
		);
		$this->assertNotTag(
			array(
				'class' => 'wp-media-buttons',
			),
			$output
		);
	}
}
