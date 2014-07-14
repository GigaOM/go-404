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
}// END class