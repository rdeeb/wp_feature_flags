<?php
/**
 * Class ff_FeatureFlag
 * This class represents a feature flag in the system and the way it can be interacted with
 *
 * @package wp_feature_flags
 * @author Ramy Deeb
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ff_FeatureFlag' ) ) {
	class ff_FeatureFlag
	{
		const FF_USER_OPTION_KEY = "ff_enabled_user_options";
		const FF_SITE_OPTION_KEY = "ff_enabled_site_options";

		protected $feature;

		public function __construct( $feature )
		{
			$this->feature = $feature;
		}

		public function addToGroup( $group )
		{

		}

		public function removeFromGroup( $group )
		{

		}

		/**
		 * Adds this feature flag to the list of active feature flags of a user
		 *
		 * @param int $user_id the user id to activate this feature flag for
		 * @throws Exception
		 */
		public function addToUser( $user_id = 0 )
		{
			if ( $user_id !== 0 && ! $this->userIdExists( $user_id ) ) throw new Exception( "User with id '${user_id}' not found." );

			$user_ff_string = get_user_option( self::FF_USER_OPTION_KEY, $user_id );

			update_user_option( $user_id, self::FF_USER_OPTION_KEY, $this->addFeatureToString( $user_ff_string ) );
		}

		/**
		 * Removes this feature from the list of active features
		 *
		 * @param int $user_id the user id to de-activate this feature flag for
		 * @throws Exception
		 */
		public function removeFromUser( $user_id = 0 )
		{
			if ( $user_id !== 0 && ! $this->userIdExists( $user_id ) ) throw new Exception( "User with id '${user_id}' not found." );

			$user_ff_string = get_user_option( self::FF_USER_OPTION_KEY, $user_id );

			update_user_option( $user_id, self::FF_USER_OPTION_KEY, $this->removeFeatureFromString( $user_ff_string ) );
		}

		public function addToPercentage( $percentage )
		{

		}

		public function removePercentage( $percentage )
		{

		}

		/**
		 * Adds this feature to the list of active features for a site
		 */
		public function globalEnable()
		{
			$site_ff_string = get_option( self::FF_SITE_OPTION_KEY, "" );

			update_site_option( self::FF_SITE_OPTION_KEY, $this->addFeatureToString( $site_ff_string ) );
		}

		/**
		 * Remove this feature from the active list of features for the site
		 */
		public function globalDisable()
		{
			$site_ff_string = get_option( self::FF_SITE_OPTION_KEY, "" );

			update_site_option( self::FF_SITE_OPTION_KEY, $this->removeFeatureFromString( $site_ff_string ) );
		}

		/**
		 * Verifies if a user has an specified feature flag active
		 *
		 * @param $user_id
		 * @return bool
		 * @throws Exception
		 */
		public function isEnabledForUser( $user_id = 0 )
		{
			if ( $user_id !== 0 && ! $this->userIdExists( $user_id ) ) throw new Exception( "User with id '${user_id}' not found." );

			// First we verify if the feature flag is enabled site wide?
			$site_ff_string = get_option( self::FF_SITE_OPTION_KEY, "" );
			if ( strpos( $site_ff_string, $this->feature ) !== false ) return true;

			// Then we verify the user group to check if the user group has the option active
			# Need to implement Groups

			// Lastly we verify if the user has the feature flag active for him
			$user_ff_string = get_user_option( self::FF_USER_OPTION_KEY, $user_id );
			if ( strpos( $user_ff_string, $this->feature ) !== false ) return true;

			// If all these checks failed then the user doesn't have the FF active
			return false;
		}

		public function toObject() {
			return (object) [
				"name" => $this->feature
			];
		}

		/**
		 * Checks if a user exists
		 *
		 * @param int $user_id User ID to check if exists
		 * @return bool
		 */
		protected function userIdExists( $user_id )
		{
			if ( $user_id instanceof WP_User ) {
				$user_id = $user_id->ID;
			}

			return (bool)get_user_by( 'id', $user_id );
		}

		/**
		 * Adds the current feature to a string
		 *
		 * @param string $string
		 * @return string
		 */
		protected function addFeatureToString( $string )
		{
			if ( $string === "" ) {
				return $this->feature;
			}

			if ( strpos( $string, $this->feature ) === false ) {
				return $string . "|" . $this->feature;
			}

			return $string;
		}

		/**
		 * Removes the current feature from a string
		 *
		 * @param string $string
		 * @return string
		 */
		protected function removeFeatureFromString( $string )
		{
			if ( $string === $this->feature ) {
				return "";
			}

			if ( strpos( $string, "|" . $this->feature ) !== false ) {
				return str_replace( "|" . $this->feature, "", $string );
			}

			return $string;
		}

	}
}
