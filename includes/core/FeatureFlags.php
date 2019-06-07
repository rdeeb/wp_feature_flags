<?php
/**
 * Class ff_FeatureFlags
 * This class is the one that handles the main logic for the feature flags, knows how to interact with WP Backend and
 * returns the required values to the helper & api functions
 *
 * @package wp_feature_flags
 * @author Ramy Deeb
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ff_FeatureFlags' ) ) {
	class ff_FeatureFlags extends ff_Singleton
	{

		protected $feature_flags = array();

		/**
		 * Returns an array of the current active feature flags objects
		 *
		 * @return array
		 */
		public function getFeatures()
		{
			// On the 20th of March of 2019, WP ended support for PHP 5.2 -> 5.5 enabling the use of anonymous functions
			return array_map( function ( $feature ) {
				return new ff_FeatureFlag( $feature );
			}, $this->feature_flags );
		}

		/**
		 * Adds a feature to the feature list
		 *
		 * @param string $feature
		 */
		public function addFeature( $feature )
		{
			if ( ! in_array( $feature, $this->feature_flags ) ) {
				$this->feature_flags[] = $feature;
			}
		}

		/**
		 * Removes a feature from the feature list
		 * @param string $feature
		 */
		public function removeFeature( $feature )
		{

			if ( $offset = array_search( $feature, $this->feature_flags ) ) {
				$this->feature_flags = array_slice( $this->feature_flags, $offset, 1 );
				# Need to unmount the feature flag from the DB
			}
		}

		/**
		 * Returns an specific feature flag object
		 *
		 * @param $feature
		 * @return ff_FeatureFlag
		 * @throws Exception
		 */
		public function getFeature( $feature )
		{
			if ( ! in_array( $feature, $this->feature_flags ) ) throw new Exception( "The feature flag '${feature}' has not been initialized." );

			return new ff_FeatureFlag( $feature );
		}

	}
}
