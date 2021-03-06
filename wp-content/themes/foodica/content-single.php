<?php
$post_layout = get_post_meta( get_the_ID(), '_foodica_post_layout', true );

if ( $post_layout == 'column-full' ) {
	$size = "foodica-loop-full";
} else {
	$size = "foodica-loop-sticky";
}
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) { ?>
        <div class="post-thumb">
			<?php the_post_thumbnail( $size, array( 'class' => 'photo' ) ); ?>
        </div>
	<?php } ?>

    <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <div class="entry-meta">
			<?php printf( '<span class="entry-author">%s ', __( 'Dodany przez', 'foodica' ) );
			the_author_posts_link();
			print( '</span>' ); ?>
            <span class="entry-date"><?php _e( 'dnia', 'foodica' ); ?> <?php printf( '<time class="entry-date" datetime="%1$s">%2$s</time> ', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?></span>
            <span class="entry-category"><?php _e( 'w', 'foodica' ); ?> <?php the_category( ', ' ); ?></span>
        </div>
    </header><!-- .entry-header -->


    <div class="entry-content">
		<?php the_content(); ?>
        <div class="clear"></div>

    </div><!-- .entry-content -->



    <?php
    if (is_user_logged_in()) {
        global $wpdb;
        $recipeIngredientsTableName = $wpdb->prefix . 'favourite_user_recipes';
        $recipeId                   = get_the_ID();
        $userId = get_current_user_id();

        $favourited = $wpdb->get_results("Select * FROM $recipeIngredientsTableName WHERE recipes_id = $recipeId AND user_id = $userId");
    ?>
    <div
            id="favourite_recipes_data"
            style="text-align:center"
            data-home-url="<?= home_url() ?>"
            data-user-id="<?= $userId ?>"
            data-recipe-id="<?= $recipeId ?>"
    >
        <button id="favourite_recipes_btn_add" <?php if(!empty($favourited)) { echo 'style="display:none"';}?>>
            Dodaj do ulubionych
        </button>
        <button id="favourite_recipes_btn_del" <?php if(empty($favourited)) { echo 'style="display:none"';}?>>
            Usuń z ulubionych
        </button>
    </div>

    <?php
    }

    $postId = get_the_ID();

    $recipeIngredientsTableName = $wpdb->prefix . 'recipe_ingredients_items';
    $ingredientsTableName = $wpdb->prefix . 'ingredients';
    $ingredientUnitsTableName = $wpdb->prefix . 'ingredients_units';

    $ingredients = $wpdb->get_results("
        SELECT $recipeIngredientsTableName.quantity, $ingredientsTableName.name, $ingredientsTableName.id, $ingredientUnitsTableName.name AS unit
        FROM $recipeIngredientsTableName
        JOIN $ingredientsTableName ON $recipeIngredientsTableName.ingredient_id = $ingredientsTableName.id
        JOIN $ingredientUnitsTableName ON $recipeIngredientsTableName.unit_id = $ingredientUnitsTableName.id 
        WHERE post_id = $postId
    ");

    if (!empty($ingredients)) {
    ?>
        <div id="recipe-ingredients-ingredients">
            <div class="recipe-ingredients-ingredients-header">
                <h4>Składniki</h4>
            </div>

            <div id="recipe-ingredients-ingredients-servings">
                Porcje
                <input type="number" min="1" value="1">
            </div>

            <div id="recipe-ingredients-ingredients-list">
                <table class="recipe-table">
                    <thead>
                        <tr>
                            <th>Nazwa składnika</th>
                            <th>Ilość </th>
                            <th>Jednostka </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <tr>
                                <td>
                                    <div>
                                        <input type="checkbox" id ="check<?= $ingredient->name ?>">
                                        <label for="check<?= $ingredient->name ?>"><?= $ingredient->name ?></label>
                                    </div>
                                </td>
                                <td id ="<?= $ingredient->id ?>" class="ingredient-quantity" data-default-quantity="<?= $ingredient->quantity ?>" value = "<?= $ingredient->quantity ?>">
                                    <?= $ingredient->quantity ?> </td>
                                <?php
                                    if($ingredient->unit == "Mililitr"){
                                ?>
                                        <td>
                                            <div" class="recipe-ingredients-ingredients-select">
                                                <select class="select" id= "select<?= $ingredient->id ?>">
                                                    <option value="Mililitr">Mililitr</option> 
                                                    <option value="Szklanka">Szklanka</option>
                                                </select>
                                            </div>
                                        </td>
                               <?php     }
                                    else{
                                    ?>

                                        <td class="ingredient-unit"> <?= $ingredient->unit ?> </td>
                                <?php    }  ?>

                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php
    $tableName = $wpdb->prefix . 'recipe_steps';
    $steps = $wpdb->get_results("SELECT step FROM $tableName WHERE post_id = $postId");

    if (!empty($steps)) {
        $stepNumber = 1;
    ?>
        <div id="recipe-steps">
            <div class="recipe-steps-header">
                <h4>Instrukcja wykonania</h4>
            </div>
            <div class="recipe-steps-content">
	            <?php foreach ($steps as $step) { ?>
                    <div class="recipe-steps-step">
                        <h5>Krok <?= $stepNumber ?></h5>
			            <?= $step->step ?>
                    </div>
                <?php $stepNumber++; } ?>
            </div>
        </div>
    <?php } ?>

    <?php if(!get_the_ID()) {
	    echo '';
	    echo 'The ID of this post is:';
	    echo get_the_ID();
	    echo 'And the ID of the user is:';
	    echo get_current_user_id();
    }
    ?>
</article><!-- #post-## -->

<footer class="entry-footer">
	<?php
	wp_link_pages( array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'foodica' ),
		'after'  => '</div>',
	) );
	?>

	<?php the_tags( '<div class="tag_list">' . __( '<h4>Tagi</h4>', 'foodica' ) . ' ', ' ', '</div>' ); ?>

    <div class="share">
        <div class="clear"></div>
    </div>

    <div class="prevnext">
		<?php
		$previous_post = get_previous_post();
		$next_post     = get_next_post();
		if ( $previous_post != null ) {
			?>
            <div class="previous_post_pag">
            <div class="prevnext_container">
				<?php if ( has_post_thumbnail( $previous_post->ID ) ) {
					echo '<a href="' . esc_url( get_permalink( $previous_post->ID ) ) . '" title="' . esc_attr( $previous_post->post_title ) . '">';
					echo get_the_post_thumbnail( $previous_post->ID, 'foodica-prevnext-small' );
					echo '</a>';
				} ?>
                <a class="prevnext_title" href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>"
                   title="<?php echo esc_attr( $previous_post->post_title ); ?>"><?php echo esc_html( $previous_post->post_title ); ?></a>
            </div>
            </div><?php
		}

		if ( $next_post != null ) {
			?>
            <div class="next_post_pag">
            <div class="prevnext_container">
                <a class="prevnext_title" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"
                   title="<?php echo esc_attr( $next_post->post_title ); ?>"><?php echo esc_html( $next_post->post_title ); ?></a>
				<?php if ( has_post_thumbnail( $next_post->ID ) ) {
					echo '<a href="' . esc_url( get_permalink( $next_post->ID ) ) . '" title="' . esc_attr( $next_post->post_title ) . '">';
					echo get_the_post_thumbnail( $next_post->ID, 'foodica-prevnext-small' );
					echo '</a>';
				} ?>
            </div>
            </div><?php
		}
		?>
    </div>

</footer><!-- .entry-footer -->