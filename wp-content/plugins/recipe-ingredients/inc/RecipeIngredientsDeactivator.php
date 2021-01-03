<?php

declare( strict_types=1 );

class RecipeIngredientsDeactivator {

	public function deactivate(): void {
		$this->dropDatabaseTableForIngredients();
	}

	private function dropDatabaseTableForIngredients(): void {
		global $wpdb;

		$tableName = $wpdb->prefix . 'recipe_ingredients_items';

		echo 'dropping';

		$sql = "
			DROP TABLE $tableName
		";

		$wpdb->query( $sql );
	}
}
