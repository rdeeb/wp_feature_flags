<?php
/**
 * Public helpers for quick access to the feature flags API inside the WP environment
 *
 * @package wp_feature_flags
 * @author Ramy Deeb
 */


if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'ff_is_feature_enabled' ) ) {
	/**
	 * Checks if a feature flag is enabled
	 *
	 * @param string $feature The feature to work on
	 * @throws Exception
	 */
	function ff_is_feature_enabled( $feature )
	{
		ff_FeatureFlags::getInstance()->getFeature( $feature )->isEnabledForUser();
	}
}

if ( ! function_exists( 'ff_activate_feature' ) ) {
	/**
	 * Activates a feature globally
	 *
	 * @param string $feature The feature to work on
	 * @throws Exception
	 */
	function ff_activate_feature( $feature )
	{
		ff_FeatureFlags::getInstance()->getFeature( $feature )->globalEnable();
	}
}

if ( ! function_exists( 'ff_disable_feature' ) ) {
	/**
	 * Disables a feature globally
	 *
	 * @param string $feature The feature to work on
	 * @throws Exception
	 */
	function ff_disable_feature( $feature )
	{
		ff_FeatureFlags::getInstance()->getFeature( $feature )->globalDisable();
	}
}

if ( ! function_exists( 'ff_activate_feature_for_user' ) ) {
	/**
	 * Activates a feature for an specific user
	 *
	 * @param string $feature The feature to work on
	 * @param int $user_id the User Id, if 0 is passed it will be activated for the current user
	 * @throws Exception
	 */
	function ff_activate_feature_for_user( $feature, $user_id = 0 )
	{
		ff_FeatureFlags::getInstance()->getFeature( $feature )->addToUser( $user_id );
	}
}

if ( ! function_exists( 'ff_disable_feature_for_user' ) ) {
	/**
	 * Deactivates a feature for an specific user
	 *
	 * @param string $feature The feature to work on
	 * @param int $user_id the User Id, if 0 is passed it will be activated for the current user
	 * @throws Exception
	 */
	function ff_disable_feature_for_user( $feature, $user_id = 0 )
	{
		ff_FeatureFlags::getInstance()->getFeature( $feature )->removeFromUser( $user_id );
	}
}

if ( ! function_exists( 'ff_register_feature_flag' ) ) {
	/**
	 * Registers a new feature flag in the system
	 *
	 * @param string $feature The feature to work on
	 */
	function ff_register_feature_flag( $feature )
	{
		ff_FeatureFlags::getInstance()->addFeature( $feature );
	}
}

if ( ! function_exists( 'ff_unregister_feature_flag' ) ) {
	/**
	 * De registers a new feature flag in the system
	 *
	 * @param string $feature The feature to work on
	 */
	function ff_unregister_feature_flag( $feature )
	{
		ff_FeatureFlags::getInstance()->removeFeature( $feature );
	}
}
