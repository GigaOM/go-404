<?php
/**
 * @author Gigaom <support@gigaom.com>
 */
class GO_404
{
	private $postid_cache_group = 'go-404-url-to-postid';

	/**
	 * constructor
	 */
	public function __construct()
	{
		add_action( 'template_redirect', array( $this, 'template_redirect' ), 11 );
	}//END __construct

	/**
	 * Intercept 404 requests and see if we can resolve it by removing "junk"
	 * after the last slash (/).
	 */
	public function template_redirect()
	{
		if ( ! is_404() )
		{
			return;
		}

		$url = $this->clean_and_validate_url( $_SERVER['REQUEST_URI'] );

		if ( ! empty( $url ) )
		{
			wp_redirect( esc_url_raw( $url ) );
			exit;
		}

		global $wp_query;

		if ( empty( $wp_query->query['name'] ) )
		{
			return;
		}

		// if we have a post slug, try looking up the post by slug
		$posts = get_posts(
			array(
				'name' => $wp_query->query['name'],
				'post_status' => 'publish',
			)
		);

		if ( empty( $posts ) )
		{
			return;
		}

		wp_redirect( get_permalink( $posts[0]->ID ) );
		exit;
	}//END template_redirect

	/**
	 * attempt to clean up and validate $url.
	 *
	 * @param string $url an url to be cleaned up and validated
	 * @return a cleaned and validated url, or NULL if $url cannot be cleaned
	 *  or validated
	 */
	public function clean_and_validate_url( $url )
	{
		$url = preg_replace( '!/[^/]*?$!', '', $url );

		if ( empty( $url ) )
		{
			return NULL;
		}

		$post_id = wp_cache_get( $url, $this->postid_cache_group );
		if ( FALSE === $post_id )
		{
			$post_id = url_to_postid( $url );
			wp_cache_set( $url, $post_id, $this->postid_cache_group );
		}//end if

		if ( 0 == $post_id )
		{
			return NULL;
		}

		return get_permalink( $post_id );
	}//END clean_and_validate_url
}//END class

/**
 * The singleton
 */
function go_404()
{
	global $go_404;

	if ( ! isset( $go_404 ) )
	{
		$go_404 = new GO_404();
	}//END if

	return $go_404;
}//END go_404
