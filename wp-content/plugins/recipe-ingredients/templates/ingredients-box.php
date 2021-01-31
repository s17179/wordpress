<?php

global $wpdb;

$tableName = $wpdb->prefix . 'recipe_ingredients_items';
$unitsTableName = $wpdb->prefix . 'ingredients_units';
$allIngredientsTableName = $wpdb->prefix . 'ingredients';
$ingredientUnitsTableName = $wpdb->prefix . 'ingredients_units';

$postId = get_the_ID();
$recipeSelectedIngredients = $wpdb->get_results( "
SELECT $tableName.quantity, $tableName.ingredient_id, $unitsTableName.id AS unit_id, $unitsTableName.name AS unit_name 
FROM $tableName 
JOIN $unitsTableName ON $tableName.unit_id = $unitsTableName.id 
WHERE post_id = $postId
");
$ingredients = $wpdb->get_results("SELECT id, name FROM $allIngredientsTableName ORDER BY name");
$ingredientUnits = $wpdb->get_results("SELECT id, name FROM $ingredientUnitsTableName ORDER BY name");

$ingredientsExist = count($recipeSelectedIngredients) > 0;

$count = 0;
?>

<table>
    <thead>
        <tr>
            <th>Nazwa składnika</th>
            <th>Ilość</th>
            <th>Jednostka</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="new-recipe-ingredients-tbody">
        <?php
        if (!$ingredientsExist) {
        ?>
            <tr>
                <td class="new-recipe-ingredients-tbody-td">
                    <select name="ri_ingredients[<?= $count ?>][ingredientId]" class="ri-ingredients-select">
				        <?php foreach ($ingredients as $ingredient): ?>
                            <option value="<?= $ingredient->id ?>">
						        <?= $ingredient->name ?>
                            </option>
				        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="ri_ingredients[<?= $count ?>][quantity]" value="0">
                </td>
                <td>
                    <select name="ri_ingredients[<?= $count ?>][unitId]">
				        <?php foreach ($ingredientUnits as $unit): ?>
                            <option value="<?= $unit->id ?>">
						        <?= $unit->name ?>
                            </option>
				        <?php endforeach; ?>
                    </select>
                </td>
		        <?php if ($count > 0): ?>
                    <td>
                        <button class="button recipe-ingredients-remove">Usuń składnik z przepisu</button>
                    </td>
		        <?php endif; ?>
            </tr>
        <?php
        } else {
            foreach ($recipeSelectedIngredients as $recipeIngredient) {
        ?>
            <tr>
                <td class="new-recipe-ingredients-tbody-td">
                    <select name="ri_ingredients[<?= $count ?>][ingredientId]" class="ri-ingredients-select">
                        <?php foreach ($ingredients as $ingredient): ?>
                            <option value="<?= $ingredient->id ?>" <?php if ($recipeIngredient->ingredient_id === $ingredient->id) { echo 'selected'; } ?>>
                                <?= $ingredient->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="ri_ingredients[<?= $count ?>][quantity]" value="<?= $recipeIngredient->quantity ?>">
                </td>
                <td>
                    <select name="ri_ingredients[<?= $count ?>][unitId]">
                        <?php foreach ($ingredientUnits as $unit): ?>
                            <option value="<?= $unit->id ?>" <?php if ($recipeIngredient->unit_id === $unit->id) { echo 'selected'; } ?>>
                                <?= $unit->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <?php if ($count > 0): ?>
                    <td>
                        <button class="button recipe-ingredients-remove">Usuń składnik z przepisu</button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php
            $count++;
            }
        }
        ?>
    </tbody>
</table>

<div id="ri-ingredients-next-count" style="display: none;"><?= $count ?></div>

<hr>

<button id="new-recipe-ingredients-button" class="button">Dodaj nowy składnik do przepisu</button>