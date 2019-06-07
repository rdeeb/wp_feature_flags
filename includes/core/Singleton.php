<?php
/**
 * Class ff_Singleton
 * A basic singleton abstract class
 *
 * @package wp_feature_flags
 * @author Ramy Deeb
 */

if ( ! class_exists( 'ff_Singleton' ) ) {
	abstract class ff_Singleton
	{
		protected static $instance;

		private function __construct()
		{
			// Private to disabled instantiation.
		}

		/**
		 * Create or retrieve the instance of our database client.
		 *
		 * @return static
		 */
		public static function getInstance()
		{
			if (is_null(static::$instance)) {
				static::$instance = new static;
			}

			return static::$instance;
		}

		/**
		 * Disable the cloning of this class.
		 *
		 * @return void
		 * @throws Exception
		 */
		final public function __clone()
		{
			throw new Exception('Can\'t clone a singleton.');
		}

		/**
		 * Disable the wakeup of this class.
		 *
		 * @return void
		 * @throws Exception
		 */
		final public function __wakeup()
		{
			throw new Exception('Can\'t wake up a singleton.');
		}
	}
}
