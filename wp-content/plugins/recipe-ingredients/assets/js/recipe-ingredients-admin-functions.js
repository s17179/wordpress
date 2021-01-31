jQuery(document).ready(function($) {
    let riIngredientsCounter = $('#ri-ingredients-next-count').text();

    $(document).on('click', '#new-recipe-ingredients-button', function (e) {
        e.preventDefault();

        addNewIngredient();
    });

    $(document).on('click', 'button.recipe-ingredients-remove', function (e) {
        e.preventDefault();

        $(this).parent().parent().remove();
    });

    function addNewIngredient() {
        const tbody = $('#new-recipe-ingredients-tbody');
        const tr = tbody.find('tr:first').clone();
        const lastTr = tbody.find('tr:last');

        tr.find('option').removeAttr('selected');
        tr.find('input').attr('value', 0);

        tr.append('<td><button class="button recipe-ingredients-remove">Usuń składnik z przepisu</button></td>');

        tr.find('select, input').each(function () {
            const name = $(this).attr('name');
            const replacedName = name.replace('[0]', `[${riIngredientsCounter}]`);
            $(this).attr('name', replacedName);
        });

        lastTr.after(tr);

        riIngredientsCounter++;
    }
});
