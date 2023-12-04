<?php
require '../dbConnect.php';

$sqlRecipeGallery = "SELECT recipe_id, recipe_name, recipe_img FROM hoyomeals_recipes";
$stmtRecipeGallery = $conn->prepare($sqlRecipeGallery);
$stmtRecipeGallery->execute();
$recipeGallery = $stmtRecipeGallery->fetchAll(PDO::FETCH_ASSOC);

$sqlIngredient = "SELECT ingredient_name, ingredient_img, ingredient_description FROM hoyomeals_ingredients";
$stmtIngredient = $conn->prepare($sqlIngredient);
$stmtIngredient->execute();
$ingredients = $stmtIngredient->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../script/script.js"></script>

    <title>!TITLE!</title>
    <meta name="description" content="!DESCRIPTION!">
    <meta name="keywords" content="!KEYWORDS!">
    <style>
        #colorTheme {
            background-color: #EF7A35;
        }

        h3 {
            border-bottom: 1px solid #EF7A35;
        }

        .recipe_div {
            display: none;
        }

        .recipeSelection_div {
            display: block;
        }
    </style>
    <script>


        function showRecipeGallery() {
            let recipeSelectionDiv = document.querySelector('.recipeSelection_div');
            let recipeDiv = document.querySelector('.recipe_div');

            if (recipeSelectionDiv && recipeDiv) {
                recipeSelectionDiv.style.display = 'block';
                recipeDiv.style.display = 'none';
            }
        };

        function showRecipe(recipeId) {
            // AJAX call to getRecipe.php
            $.ajax({
                type: 'POST',
                url: '../php/getRecipe.php',
                data: {
                    recID: recipeId
                },
                success: function(response) {
                    // Populate the recipe_div with the response
                    $('.recipe_div').html(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });

            let recipeSelectionDiv = document.querySelector('.recipeSelection_div');
            let recipeDiv = document.querySelector('.recipe_div');

            if (recipeSelectionDiv && recipeDiv) {
                recipeSelectionDiv.style.display = 'none';
                recipeDiv.style.display = 'block';
            }
        };

        let ingredientDescription = "";
        let ingredientImg = "";

        <?php foreach ($ingredients as $ingredient) : ?>
            if (localStorage.getItem("ingredient_img_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>") === null) {
                ingredientImg = "<?php echo base64_encode($ingredient['ingredient_img']); ?>";
                localStorage.setItem("ingredient_img_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>", ingredientImg);
            };

            if (localStorage.getItem("ingredient_description_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>") === null) {
                ingredientDescription = <?php echo json_encode($ingredient['ingredient_description']); ?>;
                localStorage.setItem("ingredient_description_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>", ingredientDescription);
            };
        <?php endforeach; ?>

        function displayIngredientImg(ingredient, idIncrementer) {
            let key = "ingredient_img_" + ingredient;
            let imgData = localStorage.getItem(key);

            if (imgData) {
                document.querySelector("#displayIngredientImg_" + idIncrementer).innerHTML =
                    "<img class='article-icons' alt='alt_text' src='data:image/*;base64," + imgData + "' alt='" + ingredient + "'>";
            } else {
                document.querySelector("#displayIngredientImg_" + idIncrementer).innerHTML = "Image not found for " + ingredient + ".";
            }
        };

        function displayIngredientDescription(ingredient, idIncrementer) {
            let key = "ingredient_description_" + ingredient;
            let description = localStorage.getItem(key);

            if (description) {
                document.querySelector("#displayIngredientDescription_" + idIncrementer).innerHTML = description;
            } else {
                document.querySelector("#displayIngredientDescription_" + idIncrementer).innerHTML = "Description not found for " + ingredient + ".";
            }
        };
    </script>
</head>

<body>
    <!-- Start of site skeleton structure -->
    <div class="grid-container">
        <div id="inc-header"></div>
        <script>
            $(function() {
                $("#inc-header").load("../structure/header.html")
            });
        </script>
        <div id="inc-top-nav"></div>
        <script>
            $(function() {
                $("#inc-top-nav").load("../structure/top_nav.html")
            });
        </script>
        <div id="inc-side-nav"></div>
        <script>
            $(function() {
                $("#inc-side-nav").load("../structure/side_nav.html")
            });
        </script>
        <div id="inc-left-ad">
            <div class="left-ad"><img src="/hoyomeals/img/icon/left-ad1.jpg" alt=""></div>
        </div>
        <main onclick="hideSideNav()">
            <div id="head-content-ad">
                <div class="content-ad"><img src="/hoyomeals/img/icon/ad1.png" alt="header_ad"></div>
            </div>

            <div class="disclaimerHeader">
                This is an academic site.
                <br>All recipes are fictional. DO NOT ATTEMPT!
            </div>
            <!-- End of site skeleton structure -->

            <div class="main-content-div">

                <div style="margin-bottom: 15px;"><a href="../hoyomeals/index.html">Hoyomeals</a> > <a href="#" onclick="showRecipeGallery()">Meat</a></div>

                <div class="recipeSelection_div">
                    <div class="page-title">
                        <h1 style="text-align: center;">Meats</h1>
                    </div>

                    <div class="parallelogram-title" id="colorTheme">
                        <h2>Trouble deciding? <a href="#">Have a random recipe!</a> </h2>
                    </div>

                    <div class="recipeGallery">
                        <?php foreach ($recipeGallery as $recipeGallerys) : ?>
                            <figure>
                                <img src="data:image/jpeg;base64,<?= base64_encode($recipeGallerys['recipe_img']) ?>" alt="Recipe Image" onclick="showRecipe(<?= $recipeGallerys['recipe_id'] ?>)">
                                <figcaption><?= $recipeGallerys['recipe_name'] ?></figcaption>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="recipe_div">
                </div>

                <!-- Start of site skeleton structure -->
                <div id="tail-content-ad">
                    <div class="content-ad"></div>
                </div>
            </div>
        </main>
        <div id="inc-right-ad">
            <div class="right-ad"><img src="/hoyomeals/img/icon/right-ad1.jpg" alt="right_ad"></div>
        </div>
        <div id="inc-footer"></div>
        <script>
            $(function() {
                $("#inc-footer").load("/Hoyomeals/structure/footer.html")
            });
        </script>
    </div>
    <!-- End of site skeleton structure -->
</body>

</html>