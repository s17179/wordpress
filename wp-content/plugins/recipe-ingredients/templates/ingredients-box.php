<?php

global $wpdb;

$tableName = $wpdb->prefix . 'recipe_ingredients_items';

$postId = get_the_ID();
$ingredients = $wpdb->get_results("SELECT name, quantity, unit FROM $tableName WHERE post_id = $postId");

$ingredientsExist = count($ingredients) > 0;

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
                <td>
                    <input type="text" name="ri_ingredients[0][name]">
                </td>
                <td>
                    <input type="text" value="0" name="ri_ingredients[0][quantity]">
                </td>
                <td>
                    <select name="ri_ingredients[0][unit]">
                        <option>Gramy</option>
                    </select>
                </td>
            </tr>
        <?php
        } else {
            $count = 0;

            foreach ($ingredients as $ingredient) {
        ?>
            <tr>
                <td>
                    <input type="text" name="ri_ingredients[<?= $count ?>][name]" value="<?= $ingredient->name ?>">
                </td>
                <td>
                    <input type="text" name="ri_ingredients[<?= $count ?>][quantity]" value="<?= $ingredient->quantity ?>">
                </td>
                <td>
                    <select name="ri_ingredients[<?= $count ?>][unit]">
                        <option>Gramy</option>
                    </select>
                </td>
                <?php if ($count > 0): ?>
                    <td>
                        <button class="button recipe-ingredients-remove">Usuń składnik</button>
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

<hr>

<button id="new-recipe-ingredients-button" class="button">Dodaj nowy składnik</button>