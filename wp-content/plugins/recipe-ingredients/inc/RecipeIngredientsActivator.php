<?php

declare( strict_types=1 );

class RecipeIngredientsActivator {

	public function activate(): void {
		$this->createDatabaseTableForRecipeIngredientConnections();
		$this->createDatabaseTableForIngredients();
		$this->createDatabaseTableForIngredientUnits();
		$this->createDatabaseTableForRecipeSteps();
	}

	private function createDatabaseTableForRecipeSteps(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'recipe_steps';
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $tableName (
			    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    step TEXT NOT NULL,
			    post_id BIGINT(20) UNSIGNED NOT NULL,
			    FOREIGN KEY (post_id) REFERENCES wp_posts(id)
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	private function createDatabaseTableForIngredientUnits(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'ingredients_units';
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $tableName (
			    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    name TEXT NOT NULL
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	private function createDatabaseTableForIngredients(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'ingredients';
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $tableName (
			    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    name TEXT NOT NULL
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	private function createDatabaseTableForRecipeIngredientConnections(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'recipe_ingredients_items';
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $tableName (
			    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    quantity BIGINT(20) UNSIGNED NOT NULL,
			    unit_id BIGINT(20) UNSIGNED NOT NULL,
			    ingredient_id BIGINT(20) UNSIGNED NOT NULL,
			    post_id BIGINT(20) UNSIGNED NOT NULL,
			    FOREIGN KEY (post_id) REFERENCES wp_posts(id),
			    FOREIGN KEY (ingredient_id) REFERENCES wp_ingredients(id),
			    FOREIGN KEY (unit_id) REFERENCES wp_ingredients_units(id)
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}
