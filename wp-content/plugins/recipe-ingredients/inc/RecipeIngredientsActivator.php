<?php

declare( strict_types=1 );

class RecipeIngredientsActivator {

	public function activate(): void {
		$this->createDatabaseTableForRecipeIngredientConnections();
		$this->createDatabaseTableForIngredients();
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
			    quantity TEXT NOT NULL,
			    unit TEXT NOT NULL,
			    ingredient_id BIGINT(20) UNSIGNED NOT NULL,
			    post_id BIGINT(20) UNSIGNED NOT NULL,
			    FOREIGN KEY (post_id) REFERENCES wp_posts(id) ON DELETE CASCADE,
			    FOREIGN KEY (ingredient_id) REFERENCES wp_ingredients(id) ON DELETE CASCADE
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}
