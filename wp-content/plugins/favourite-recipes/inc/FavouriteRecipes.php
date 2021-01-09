<?php

declare( strict_types=1 );

class FavouriteRecipes {

	public function __construct() {
		add_action('rest_api_init', function(){
			register_rest_route('favourites/v1', 'add', [
				'methods' => 'POST',
				'callback' => 'add_to_favourites'
			]);

			register_rest_route('favourites/v1', 'remove/(?P<>)',[
				'methods' => 'POST',
				'callback' => 'remove_from_favourites'
			]);
		});
	}

	function add_to_favourites(){
		global $wpdb;
		//db script to
	}

	function remove_from_favourites(){
		
	}
}