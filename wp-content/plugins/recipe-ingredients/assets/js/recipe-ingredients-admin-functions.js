jQuery(document).ready(function($) {
    let riIngredientsCounter = $('#ri-ingredients-next-count').text();
    let riStepCounter = $('#ri-recipe-steps-next-count').text();

    $(document).on('click', '#new-recipe-ingredients-button', function (e) {
        e.preventDefault();

        addNewIngredient();
    });

    $(document).on('click', 'button.recipe-ingredients-remove', function (e) {
        e.preventDefault();

        $(this).parent().parent().remove();
    });

    $(document).on('click', '#new-recipe-step-button', function (e) {
        e.preventDefault();

        const stepsDiv = $('#recipe-ingredients-steps');
        const lastStepDiv = stepsDiv.find('div.recipe-ingredients-step-block:first').clone();
        lastStepDiv.append('<button class="button recipe-ingredients-step-remove">Usuń krok z przepisu</button>');

        const textarea = lastStepDiv.find('textarea');
        textarea.attr('name', textarea.attr('name').replace('[0]', `[${riStepCounter++}]`));
        textarea.val('');

        stepsDiv.append(lastStepDiv);

        reindexStepNumbers();
    });

    $(document).on('click', '.recipe-ingredients-step-remove', function (e) {
        e.preventDefault();

        $(this).parent().remove();

        reindexStepNumbers();
    });

    function reindexStepNumbers() {
        let numberCounter = 1;

        $('#recipe-ingredients-steps').find('span.recipe-ingredients-step-number').each(function () {
            $(this).text(numberCounter);
            numberCounter++;
        });
    }

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
