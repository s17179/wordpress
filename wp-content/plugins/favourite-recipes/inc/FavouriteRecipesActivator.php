<?php

class FavouriteRecipesActivator{
	public function activate(): void {
		$this->createDatabaseTableForFavourites();
	}

	private function createDatabaseTableForFavourites(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'favourite_user_recipes';
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "
			CREATE TABLE $tableName (
			    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			    recipes_id BIGINT(20) UNSIGNED NOT NULL,
				user_id BIGINT(20) UNSIGNED NOT NULL,
			    FOREIGN KEY (recipes_id) REFERENCES wp_posts(ID) ON DELETE CASCADE,
				FOREIGN KEY (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE
			) $charsetCollate
		";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}