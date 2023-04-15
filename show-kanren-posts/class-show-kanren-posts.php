<?php
/**
 * Show Kanren Posts
 *
 * @package           Show_Kanren_Posts
 */

/**
 * Class Show_Kanren_Posts
 */
class Show_Kanren_Posts {

    /**
     * Register shortcodes
     */
    public function __construct() {
		add_shortcode('kanren', array(&$this, 'relatedPost'));
	}

	/**
	 * Query string for sort
	 *
	 * @var bool
	 */
	private static $initiated = false;

	/**
	 * Initialization
	 */
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
	}

	/**
	 * Show related post
	 */
	public function relatedPost($atts) {
		return '<div>Hello, relatedPost!</div>';
	}

}
