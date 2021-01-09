jQuery(document).ready(function($) {
    const favouriteRecipesData = $('#favourite_recipes_data');
    const homeUrl = favouriteRecipesData.data('home-url');
    const userId = favouriteRecipesData.data('user-id');
    const recipeId = favouriteRecipesData.data('recipe-id');

    $(document).on('click', '#favourite_recipes_btn_add', function(e) {
        $.post(homeUrl + "/wp-json/favourites/v1/add/" + userId + "/" + recipeId, function(data) {
            console.log(data);
        });

        $(this).css('display', 'none');
        $('#favourite_recipes_btn_del').css('display', 'inline-block');
    });

    $(document).on('click', '#favourite_recipes_btn_del', function(e) {
        $.post(homeUrl + "/wp-json/favourites/v1/remove/" + userId + "/" + recipeId, function(data) {
            console.log(data);
        });

        $(this).css('display', 'none');
        $('#favourite_recipes_btn_add').css('display', 'inline-block');
    });
});
