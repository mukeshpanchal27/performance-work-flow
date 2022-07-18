<?php
/**
 * Tests for dominant-color module.
 *
 * @since 1.2.0
 *
 * @package performance-lab
 * @group   dominant-color
 */

use PerformanceLab\Tests\TestCase\DominantColorTestCase;

class Dominant_Color_Image_Editor_Imageick_Test extends DominantColorTestCase {
	public function set_up() {
		parent::set_up(); // TODO: Change the autogenerated stub.

		add_filter(
			'wp_image_editors',
			static function () {
				return array( 'Dominant_Color_Image_Editor_Imagick' );
			},
			100
		);
	}

	/**
	 * Test if the function returns the correct color.
	 *
	 * @dataProvider provider_get_dominant_color
	 *
	 * @covers       Dominant_Color_Image_Editor_GD::get_dominant_color
	 */
	public function test_get_dominant_color( $image_path, $expected_color, $expected_transparency ) {

		$attachment_id = $this->factory->attachment->create_upload_object( $image_path );
		wp_maybe_generate_attachment_metadata( get_post( $attachment_id ) );

		$dominant_color_data = _dominant_color_get_dominant_color_data( $attachment_id );

		$this->assertContains( $dominant_color_data['dominant_color'], $expected_color );
		$this->assertSame( $dominant_color_data['has_transparency'], $expected_transparency );
	}

	/**
	 * Test if the function returns the correct color.
	 *
	 * @dataProvider provider_get_dominant_color_invalid_images
	 *
	 * @group ms-excluded
	 *
	 * @covers       Dominant_Color_Image_Editor_GD::get_dominant_color
	 */
	public function test_get_dominant_color_invalid( $image_path, $expected_color, $expected_transparency ) {

		$attachment_id = $this->factory->attachment->create_upload_object( $image_path );
		wp_maybe_generate_attachment_metadata( get_post( $attachment_id ) );

		$dominant_color_data = _dominant_color_get_dominant_color_data( $attachment_id );

		$this->assertContains( $dominant_color_data['dominant_color'], $expected_color );
		$this->assertSame( $dominant_color_data['has_transparency'], $expected_transparency );
	}

	/**
	 * Test if the function returns the correct color.
	 *
	 * @dataProvider provider_get_dominant_color_none_images
	 *
	 * @covers       Dominant_Color_Image_Editor_GD::get_dominant_color
	 */
	public function test_get_dominant_color_none_images( $image_path ) {

		$attachment_id = $this->factory->attachment->create_upload_object( $image_path );
		wp_maybe_generate_attachment_metadata( get_post( $attachment_id ) );

		$dominant_color_data = _dominant_color_get_dominant_color_data( $attachment_id );

		$this->assertWPError( $dominant_color_data );
	}
}
