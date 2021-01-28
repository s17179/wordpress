jQuery(document).ready(function($) {
    const ingredientsData = $('#ingredients-data');
    const homeUrl = ingredientsData.data('home-url');

    const ingredientListMenuItem = $('#ingredient-list-menu-item');
    const newIngredientMenuItem = $('#new-ingredient-menu-item');

    const newIngredientForm = $('#new-ingredient-form');
    const ingredientListTable = $('#ingredient-list-table');

    $(document).on('click', '#ingredient-list-menu-item', function (e) {
        e.preventDefault();
        newIngredientMenuItem.removeClass('nav-tab-active');
        ingredientListMenuItem.addClass('nav-tab-active');

        newIngredientForm.fadeOut("fast", function () {
            ingredientListTable.fadeIn();
        });
    });

    $(document).on('click', '#new-ingredient-menu-item', function (e) {
        e.preventDefault()
        ingredientListMenuItem.removeClass('nav-tab-active');
        newIngredientMenuItem.addClass('nav-tab-active');

        ingredientListTable.fadeOut("fast", function () {
            newIngredientForm.fadeIn();
        });
    });

    $(document).on('click', '#ingredients-delete-ingredient-button', function(e) {
        e.preventDefault();

        const ingredientId = $(this).data('ingredient-id');

        $.post(homeUrl + "/wp-json/ingredients/v1/delete/" + ingredientId, function (data) {});

        $(this).parent().parent().remove();
    });
});
