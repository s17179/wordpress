<?php

declare( strict_types=1 );

class RecipeIngredientsDeactivator {

	public function deactivate(): void {
		$this->dropDatabaseTableForIngredients();
	}

	private function dropDatabaseTableForIngredients(): void {

	}
}
