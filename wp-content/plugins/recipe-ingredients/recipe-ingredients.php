<?php

/*
Plugin Name: Recipe Ingredients
Description: Recipe Ingredients
Version: 1.0
Author: Grupa C
*/

defined( 'ABSPATH' ) || exit;

define( 'RECIPE_INGREDIENTS_BASE_PATH', __DIR__ );

require_once RECIPE_INGREDIENTS_BASE_PATH . '/inc/RecipeIngredientsActivator.php';
require_once RECIPE_INGREDIENTS_BASE_PATH . '/inc/RecipeIngredientsDeactivator.php';
require_once RECIPE_INGREDIENTS_BASE_PATH . '/inc/RecipeIngredients.php';

$recipeIngredientsActivator = new RecipeIngredientsActivator();

register_activation_hook(__FILE__, [ $recipeIngredientsActivator, 'activate' ]);

$recipeIngredientsDeactivator = new RecipeIngredientsDeactivator();

register_deactivation_hook( __FILE__, [ $recipeIngredientsDeactivator, 'deactivate' ] );

$recipeIngredients = new RecipeIngredients();
