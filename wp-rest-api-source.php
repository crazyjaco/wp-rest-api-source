<?php
/**
 * Class WP REST API Source
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    PLugin_Name
 * @subpackage Plugin_Name/folder_path?
 */

/**
 * Example REST Source Class
 */
class Class_WP_REST_API_Target {
	/**
	 * Instance of the class; False if not instantiated yet.
	 *
	 * @var boolean
	 */
	private static $instance = false;
	/**
	 * Instantiates the Singleton if not already done and return it.
	 *
	 * @return obj  Instance of this class; false on failure
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new Class_WP_REST_API_Target;
		}
		return self::$instance;
	}
	/**
	 * Class Constructor
	 */
	function __construct() {
		add_action( 'publish_post', array( $this, 'send_post_to_target' ), 10, 2 );
	} // End function __construct.

	/**
	 * Trigger a REST call to clone the new post on the target cms.
	 *
	 * @param  number $post_id Post ID.
	 * @param  object $post    Post object.
	 */
	function send_post_to_target( $post_id, $post ) {
		$request = WP_REST_Request( 'GET', '/wp/v2/posts/' . $post_id );
		$reponse = rest_do_request();

		$status = $response->get_status();
		if ( 200 === $status ) {
			$data = $response->get_data();
			wp_safe_remote_post( $target_cms_uri, array( 'body' => $data ) );
		}
	}
} // End Class.
Class_WP_REST_API_Target::instance();
