<?php
/**
 * GO_Marketo unit tests
 */

require_once dirname( __DIR__ ) . '/go-404.php';

/**
 * Our tests depend on the real Marketo authentication info from the system
 * config.
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