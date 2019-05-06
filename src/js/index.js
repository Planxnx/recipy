const categoryFilter = (category) => {
    console.log("Filter")
    if (category == 'recipeAll') {
        $('.recipeEveryday').show(500);
        $('.recipeEasy').show(500);
        $('.recipeHealth').show(500);
        $('.recipeDessert').show(500);
        $('.recipeBaking').show(500);
        $('.recipeDrinks').show(500);
    } else if (category == 'recipeEveryday') {
        $('.recipeEveryday').show(500);
        $('.recipeEasy').hide(500);
        $('.recipeHealth').hide(500);
        $('.recipeDessert').hide(500);
        $('.recipeBaking').hide(500);
        $('.recipeDrinks').hide(500);
    } else if (category == 'recipeEasy') {
        $('.recipeEveryday').hide(500);
        $('.recipeEasy').show(500);
        $('.recipeHealth').hide(500);
        $('.recipeDessert').hide(500);
        $('.recipeBaking').hide(500);
        $('.recipeDrinks').hide(500);
    } else if (category == 'recipeHealth') {
        $('.recipeEveryday').hide(500);
        $('.recipeEasy').hide(500);
        $('.recipeHealth').show(500);
        $('.recipeDessert').hide(500);
        $('.recipeBaking').hide(500);
        $('.recipeDrinks').hide(500);
    } else if (category == 'recipeDessert') {
        $('.recipeEveryday').hide(500);
        $('.recipeEasy').hide(500);
        $('.recipeHealth').hide(500);
        $('.recipeDessert').show(500);
        $('.recipeBaking').hide(500);
        $('.recipeDrinks').hide(500);
    }else if (category == 'recipeBaking') {
        $('.recipeEveryday').hide(500);
        $('.recipeEasy').hide(500);
        $('.recipeHealth').hide(500);
        $('.recipeDessert').hide(500);
        $('.recipeBaking').show(500);
        $('.recipeDrinks').hide(500);
    }else if (category == 'recipeDrinks') {
        $('.recipeEveryday').hide(500);
        $('.recipeEasy').hide(500);
        $('.recipeHealth').hide(500);
        $('.recipeDessert').hide(500);
        $('.recipeBaking').hide(500);
        $('.recipeDrinks').show(500);
    }
}