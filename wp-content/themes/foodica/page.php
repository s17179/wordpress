<?php
/**
 * The Template for displaying all single posts.
 */


get_header(); ?>

    <div id="slider" class="style-1">
        <ul class="slides clearfix">
            <li class="slide">
                <div class="slide-overlay">
                    <div class="slide-header">
                        <span class="cat-links">
                            <a href="<?=get_category_link(6)?>" rel="category tag">
                                Desery
                            </a>
                        </span>
                        <h3>
                            <a href="<?=get_permalink(213)?>">
                                <?=get_the_title(213)?>
                            </a>
                        </h3>
                        <div class="slide_button">
                            <a href="<?=get_permalink(213)?>">
                                Zobacz
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slide-background"
                     style="background-image:url('https://i1.wp.com/demo.wpzoom.com/foodica-lite/files/2014/10/food-2569257_1280.jpg?resize=750%2C500&ssl=1')"></div>
            </li>
        </ul>
    </div>

    <main id="main" class="site-main" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <div class="content-area">

                <?php get_template_part('content', 'page'); ?>

                <?php comments_template(); ?>

            </div>

        <?php endwhile; // end of the loop. ?>

        <?php get_sidebar(); ?>

    </main><!-- #main -->

<?php get_footer(); ?>