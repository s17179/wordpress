<?php

global $wpdb;
$prefix = $wpdb->prefix;
$ingredientTableName = $prefix . 'ingredients';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredient-name'])) {
	$ingredientName = $_POST['ingredient-name'];

	$doesIngredientAlreadyExist = $wpdb->get_results("SELECT 1 FROM $ingredientTableName WHERE name = '$ingredientName'");

	if (count($doesIngredientAlreadyExist) === 0) {
		$wpdb->insert($ingredientTableName, ['name' => $ingredientName]);
	}
}

$ingredients = $wpdb->get_results("SELECT * FROM $ingredientTableName");

?>

<div id="ingredients-data" style="display: none;" data-home-url="<?= home_url() ?>"></div>

<div id="um-settings-wrap" class="wrap">
    <h2>Składniki</h2>

    <h2 class="nav-tab-wrapper um-nav-tab-wrapper">
        <a id="ingredient-list-menu-item" class="nav-tab nav-tab-active" style="cursor: pointer">Lista składników</a>
        <a id="new-ingredient-menu-item" class="nav-tab" style="cursor: pointer">Dodaj nowy składnik</a>
    </h2>

    <div style="margin-top: 20px">
        <table id="ingredient-list-table" class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col" class='manage-column column-email column-primary'>Nazwa składnika</th>
                    <th scope="col" id='configure' class='manage-column column-configure'></th>
                </tr>
            </thead>

            <tbody id="the-list">
                <?php foreach ($ingredients as $ingredient): ?>
                    <tr>
                        <td><?= $ingredient->name ?></td>
                        <td>
                            <a id="ingredients-delete-ingredient-button" class="button" data-ingredient-id="<?= $ingredient->id ?>">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="#" id="new-ingredient-form" method="post" style="display: none">
            <table class="form-table">
                <tbody>
                <tr>
                    <th>
                        <label for="ingredient-name">Nazwa składnika</label>
                    </th>
                    <td>
                        <input type="text" id="ingredient-name" name="ingredient-name">
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Dodaj" />
            </p>
        </form>
    </div>
</div>
