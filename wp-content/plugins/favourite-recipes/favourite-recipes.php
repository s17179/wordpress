<?php
/**
 * @package  FavouriteRecipes
 */

/*
Plugin Name: Favourite Recipes
Description: Plugin used to store favourite recipes of users in the database.
Version: 1.0
Author: Grupa C
License: GPLv2
Text Domain: favourite-recipes
*/

defined('ABSPATH') or die('Don\'t do this');

define( 'FAVOURITE_INGREDIENTS_BASE_PATH', __DIR__ );


require_once FAVOURITE_INGREDIENTS_BASE_PATH . '/inc/FavouriteRecipesActivator.php';
require_once FAVOURITE_INGREDIENTS_BASE_PATH . '/inc/FavouriteRecipesDeactivator.php';
require_once FAVOURITE_INGREDIENTS_BASE_PATH . '/inc/FavouriteRecipes.php';

$favouriteRecipesActivator = new FavouriteRecipesActivator();

register_activation_hook(__FILE__, [ $favouriteRecipesActivator, 'activate' ]);

$favouriteRecipesDeactivator = new FavouriteRecipesDeactivator();

register_deactivation_hook( __FILE__, [ $favouriteRecipesDeactivator, 'deactivate' ] );

$favouriteRecipes = new FavouriteRecipes();
