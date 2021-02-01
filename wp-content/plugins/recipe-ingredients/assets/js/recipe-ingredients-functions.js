jQuery(document).ready(function($) {
    $(document).on('click', '#recipe-ingredients-ingredients-list li', function (e) {
        const checked = $(this).children('input').is(':checked');

        if (!checked) {
            $(this).children('input').prop('checked', true);
            $(this).children('label').css('text-decoration', 'line-through');
        } else {
            $(this).children('input').prop('checked', false);
            $(this).children('label').css('text-decoration', 'none');
        }
    });

    $(document).on('change', '#recipe-ingredients-ingredients-servings input', function(e) {
        const servings = $(this).val();

        const ingredientQuantityElements = $('#recipe-ingredients-ingredients-list .ingredient-quantity');

        ingredientQuantityElements.each(function (i) {
            const defaultQuantityFraction = math.fraction($(this).data('default-quantity'));

            const calculatedQuantityFraction = math.multiply(defaultQuantityFraction, servings)

            const calculatedQuantityNumber = math.number(calculatedQuantityFraction);

            const selectId =  $(this).attr("id")

            const unitElements = $('.recipe-ingredients-ingredients-select #select' + selectId.toString()).val();

            if (Number.isInteger(calculatedQuantityNumber)) {
                $(this).text(calculatedQuantityNumber);
                $(this).attr("value", calculatedQuantityNumber);
            } else {
                $(this).text(getTheWholeFromFraction(calculatedQuantityFraction));
                $(this).attr("value", calculatedQuantityFraction);
            }

            if(unitElements == "Szklanka"){
                calculateCup($(this));
            }
        });
    });

    $(document).on('change', '.recipe-ingredients-ingredients-select select', function(e) {
        const unitElements = $(this).val();

        const selectId =  $(this).attr("id")
        const name =  selectId.replace('select', '');

        const ingredientQuantityElements = $('#recipe-ingredients-ingredients-list #' + name.toString());

        const value = ingredientQuantityElements.attr("value");

        if(unitElements == "Szklanka"){
            calculateCup(ingredientQuantityElements);
        }
        else{
            ingredientQuantityElements.text(value);
        }
    
        
    });

    function getTheWholeFromFraction(fraction) {
        const n = fraction.n;
        const d = fraction.d;

        const division = n / d;

        const whole = Math.floor(division);

        const fractionPart = division % 1;

        const result = math.format(math.fraction(fractionPart));

        if (whole === 0) {
            return result;
        }

        return whole.toString() + ' ' + result;
    }


    function calculateCup(ingredientQuantityElements) {
        const cup = 250;

        const value = ingredientQuantityElements.attr("value");

        const calculatedQuantityFraction =math.fraction(value/cup);

        const calculatedQuantityNumber = math.number(calculatedQuantityFraction);

        if (Number.isInteger(calculatedQuantityNumber)) {
            ingredientQuantityElements.text(calculatedQuantityNumber);
        } else {
            ingredientQuantityElements.text(getTheWholeFromFraction(calculatedQuantityFraction));
        }
    }
});
