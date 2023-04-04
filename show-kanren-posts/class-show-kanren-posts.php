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
}
