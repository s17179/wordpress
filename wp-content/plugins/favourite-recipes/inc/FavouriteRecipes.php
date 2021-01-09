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
	}

	function add_to_favourites(){
		global $wpdb;

	}

	function remove_from_favourites($params){
		print_r($params['userId']);
		print_r($params['recipeId']);
	}
}