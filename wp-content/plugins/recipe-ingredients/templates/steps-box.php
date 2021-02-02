<?php

global $wpdb;

$tableName = $wpdb->prefix . 'recipe_steps';

$postId = get_the_ID();

$steps = $wpdb->get_results("SELECT step FROM $tableName WHERE post_id = $postId");
$stepsNumber = count( $steps );

$count = 0;
?>

<div id="recipe-ingredients-steps">
    <?php if ($stepsNumber === 0): ?>
        <div class="recipe-ingredients-step-block">
            <label class="recipe-ingredients-step-label">Krok <span class="recipe-ingredients-step-number"><?= $count + 1 ?></span></label>
            <textarea name="ri_steps[<?= $count ?>]" cols="100" rows="4" class="recipe-ingredients-step-textarea"></textarea>
        </div>
    <?php endif; ?>
	<?php foreach ($steps as $step) { ?>
        <div class="recipe-ingredients-step-block">
            <label class="recipe-ingredients-step-label">Krok <span class="recipe-ingredients-step-number"><?= $count + 1 ?></span></label>
            <textarea name="ri_steps[<?= $count ?>]" cols="100" rows="4" class="recipe-ingredients-step-textarea"><?= $step->step ?></textarea>
            <?php if ($count > 0): ?>
                <button class="button recipe-ingredients-step-remove">Usuń krok z przepisu</button>
            <?php endif; ?>
        </div>
    <?php $count++; } ?>
</div>

<button id="new-recipe-step-button" class="button">Dodaj kolejny krok do przepisu</button>

<div id="ri-recipe-steps-next-count" style="display: none;"><?= $count ?></div>
