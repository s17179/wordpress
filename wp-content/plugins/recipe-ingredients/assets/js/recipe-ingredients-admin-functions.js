jQuery(document).ready(function($) {
    let riIngredientsCounter = 1;

    $(document).on('click', '#new-recipe-ingredients-button', function (e) {
        e.preventDefault();

        addNewIngredient();
    });

    $(document).on('click', 'button.recipe-ingredients-remove', function (e) {
        e.preventDefault();

        $(this).parent().parent().remove();
    });

    function addNewIngredient() {
        $('#new-recipe-ingredients-tbody').append(
            '<tr>\n' +
            '            <td>\n' +
            '                <input type="text" name="ri_ingredients['+ riIngredientsCounter +'][name]">\n' +
            '            </td>\n' +
            '            <td>\n' +
            '                <input type="text" value="0" name="ri_ingredients['+ riIngredientsCounter +'][quantity]">\n' +
            '            </td>\n' +
            '            <td>\n' +
            '                <select name="ri_ingredients['+ riIngredientsCounter +'][unit]">\n' +
            '                    <option>Gramy</option>\n' +
            '                </select>\n' +
            '            </td>\n' +
            '            <td>\n' +
            '                <button class="button recipe-ingredients-remove">Usuń składnik</button>' +
            '            </td>\n' +
            '        </tr>'
        );

        riIngredientsCounter++;
    }
});
