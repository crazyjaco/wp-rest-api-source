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
class Class_WP_REST_API_Source {
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
			self::$instance = new Class_WP_REST_API_Source;
		}
		return self::$instance;
	}

	/**
	 * Class Constructor
	 */
	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );

		// Send to Target on Publish.
		add_action( 'publish_post', array( $this, 'send_post_to_target' ), 10, 2 );
		// Admin Interface.
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_options' ) );
	}

	function enqueue_scripts_styles() {
		wp_enqueue_script( 'wp-rest-api-source', REST_POC_URL . 'js/wp-rest-api-source.js' , array( 'wp-api', 'backbone', 'jquery', 'underscore' ), '1.0', true );
	}


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


	/*
	 ***************
	 * ADMIN PAGES *
	 ***************
	 */

	function add_options_page() {
		// @params ('new page title', 'admin menu text', 'capabilities', 'unique plugin id for querystring', 'callback to content of page')
		add_options_page( 'REST API Source', 'REST API Source', 'manage_options', 'rest-api-source', array( $this, 'create_options_page' ) );
	}

	function create_options_page() {
		?>
		<div id="post-list-table-container">
		</div>
		<script type="text/template" id="post-list-table-template" class="template">
			<h2>REST API Source</h2>
			<button>Get some posts</button>
			<table id="post-list-table">
				<th>
					<td>ID</td>
					<td>Title</td>
					<td>Button</td>
				</th>
			</table>
		</script>

		<script type="text/template" id="post-list-item-template" class="template">
			<td><%= id %></td>
			<td><%= title.rendered %></td>
			<td><button>Send to Target!</button></td>
		</script>

		<?php
	}




	function register_plugin_options() {

	}





} // End Class.
Class_WP_REST_API_Source::instance();
