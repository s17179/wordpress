<?php

declare( strict_types=1 );

class FavouriteRecipes {

	public function __construct() {
		add_action('rest_api_init', function(){
			register_rest_route('favourites/v1', 'add/(?P<userId>[0-9]+)/(?P<recipeId>[0-9]+)', [
				'methods' => 'POST',
				'callback' => [$this, 'add_to_favourites']
			]);

			register_rest_route('favourites/v1', 'remove/(?P<userId>[0-9]+)/(?P<recipeId>[0-9]+)',[
				'methods' => 'POST',
				'callback' => [$this, 'remove_from_favourites']
			]);
		});

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	function add_to_favourites($params){
		global $wpdb;
		$userId = $params['userId'];
		$recipeId = $params['recipeId'];
		$tableName = 'wp_favourite_user_recipes';

		$wpdb->insert($tableName, array(
			'recipes_id' => $recipeId,
			'user_id' => $userId
		));
	}

	function remove_from_favourites($params){
		global $wpdb;
		$userId = $params['userId'];
		$recipeId = $params['recipeId'];
		$tableName = 'wp_favourite_user_recipes';

		$wpdb->delete($tableName, array(
			'recipes_id' => $recipeId,
			'user_id' => $userId
		));
	}

	function enqueue_assets() {
		wp_enqueue_script(
			'favourite-recipes-functions',
			plugins_url( '/assets/js/favourite-recipes-functions.js', __DIR__ ),
			[ 'jquery' ]
		);
	}
}