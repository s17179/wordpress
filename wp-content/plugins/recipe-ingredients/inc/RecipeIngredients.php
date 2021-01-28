<?php

declare( strict_types=1 );

class RecipeIngredients {

	public function __construct() {
		add_action( 'init', [ $this, 'registerPostType' ] );

		add_action( 'admin_menu', [ $this, 'addIngredientsMenu' ] );

		add_action( 'add_meta_boxes', [ $this, 'addIngredientsBox' ] );

		add_action( 'save_post', [ $this, 'saveRecipe' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueAssets' ] );

		add_action('rest_api_init', function(){
			register_rest_route('ingredients/v1/delete', '/(?P<ingredientId>[0-9]+)', [
				'methods' => 'POST',
				'callback' => [$this, 'deleteIngredient']
			]);
		});
	}

	public function deleteIngredient($params): void {
		global $wpdb;

		$ingredientId = (int) $params['ingredientId'];

		$wpdb->delete($wpdb->prefix . 'ingredients', [
			'id' => $ingredientId
		]);
	}

	public function addIngredientsMenu(): void {
		add_submenu_page(
			'edit.php?post_type=recipe-ingredients',
			'Składniki',
			'Składniki',
			'manage_options',
			'recipe-ingredients-ingredients',
			[ $this, 'includeIngredientsMenu' ],
			2
		);

		wp_enqueue_script(
			'ingredients-functions',
			plugins_url( '/assets/js/ingredients-functions.js', __DIR__ ),
			[ 'jquery' ]
		);
	}

	public function includeIngredientsMenu(): void {
		include RECIPE_INGREDIENTS_BASE_PATH . '/templates/ingredients.php';
	}

	public function registerPostType(): void {
		$args = [
			'public'      => true,
			'has_archive' => true,
			'label'       => 'Przepisy',
			'menu_icon'   => 'dashicons-food',
			'labels'      => [
				'add_new_item' => 'Dodaj nowy przepis',
				'edit_item'    => 'Edytuj przepis'
			],
			'taxonomies'  => [ 'category', 'post_tag' ],
			'supports'    => [ 'title', 'editor', 'thumbnail', 'comments' ],
			'rewrite'     => [ 'slug' => 'przepisy' ],
			'menu_position' => 2
		];

		register_post_type( 'recipe-ingredients', $args );

		flush_rewrite_rules();
	}

	public function addIngredientsBox(): void {
		add_meta_box(
			'recipe-ingredients',
			'Składniki',
			[ $this, 'includeIngredientsBoxMetadata' ],
			'recipe-ingredients'
		);

		wp_enqueue_script(
			'recipe-ingredients-admin-functions',
			plugins_url( '/assets/js/recipe-ingredients-admin-functions.js', __DIR__ ),
			[ 'jquery' ]
		);
	}

	public function includeIngredientsBoxMetadata(): void {
		include RECIPE_INGREDIENTS_BASE_PATH . '/templates/ingredients-box.php';
	}

	public function enqueueAssets(): void {
		wp_enqueue_style(
			'recipe-ingredients-styles',
			plugins_url( '/assets/css/recipe-ingredients-styles.css', __DIR__ )
		);

		wp_enqueue_script(
			'math-library',
			plugins_url( '/assets/js/math.min.js', __DIR__ )
		);

		wp_enqueue_script(
			'recipe-ingredients-functions',
			plugins_url( '/assets/js/recipe-ingredients-functions.js', __DIR__ ),
			[ 'jquery' ]
		);
	}

	public function saveRecipe( $postId ): void {
		if ( ! empty( $_POST['ri_ingredients'] ) ) {
			global $wpdb;
			$tableName   = $wpdb->prefix . 'recipe_ingredients_items';
			$ingredients = $_POST['ri_ingredients'];

			$wpdb->delete(
				$tableName,
				[
					'post_id' => $postId
				]
			);

			foreach ( $ingredients as $ingredient ) {
				$name     = $ingredient['name'];
				$quantity = $ingredient['quantity'];
				$unit     = $ingredient['unit'];

				$wpdb->insert(
					$tableName,
					[
						'name'     => $name,
						'quantity' => $quantity,
						'unit'     => $unit,
						'post_id'  => $postId
					]
				);
			}
		}
	}
}
