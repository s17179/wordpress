<?php

declare( strict_types=1 );

class FavouriteRecipesDeactivator {

	public function deactivate(): void {
		$this->dropDatabaseTableForFavourites();
	}

	private function dropDatabaseTableForFavourites(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'favourite_user_recipes';

		echo 'dropping favourite recipes table';

		$sql = "
			DROP TABLE $tableName
		";

		$wpdb->query( $sql );
	}
}