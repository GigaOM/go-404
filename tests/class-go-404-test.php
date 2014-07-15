<?php
/**
 * GO_404 unit tests
 */
require_once dirname( __DIR__ ) . '/go-404.php';

/**
 * the test class
 */
class GO_404_Test extends WP_UnitTestCase
{
	/**
	 * make sure we can get an instance of our plugin
	 */
	public function test_singleton()
	{
		$this->assertTrue( function_exists( 'go_404' ) );
		$this->assertTrue( is_object( go_404() ) );
	}//END test_singleton

	/**
	 * test the url cleaner
	 */
	public function test_clean_and_validate_url()
	{
		$url = '/report/how-the-paas-market-is-moving-beyond-deployment-and-scaling/\'+trackingPixel+\'`';

		$this->assertNull( go_404()->clean_and_validate_url( $url ) );

		// now add a post with the correct slug
		register_post_type(
			'go-report',
			array(
				'public' => TRUE,
			)
		);

		$post_id = wp_insert_post(
			array(
				'post_content' => 'lalala',
				'post_name' => 'how-the-paas-market-is-moving-beyond-deployment-and-scaling',
				'post_title' => 'How the PAAS Market Is Moving Beyond Deployment And Scaling',
				'post_status' => 'publish',
				'post_type' => 'go-report',
			)
		);

		$cleaned_url = go_404()->clean_and_validate_url( $url );

		$this->assertFalse( empty( $cleaned_url ) );
		$this->assertTrue( 0 < strpos( $cleaned_url, '/go-report/' ) );
		$this->assertTrue( 0 < strpos( $cleaned_url, '/how-the-paas-market-is-moving-beyond-deployment-and-scaling' ) );
		$this->assertFalse( strpos( $cleaned_url, '\'+trackingPixel+\'`' ) );
	}//END test_clean_and_validate_url
}// END class