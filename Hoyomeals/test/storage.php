<?php
require '../dbConnect.php';

$sqlRecipe = "SELECT recipe_ingredients FROM hoyomeals_recipes WHERE recipe_id=:recID";
$stmtRecipe = $conn->prepare($sqlRecipe);
$recID = 1;
$stmtRecipe->bindParam(':recID', $recID);
$stmtRecipe->execute();
$recipes = $stmtRecipe->fetchAll(PDO::FETCH_ASSOC);

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

        <title>cName Review: Best Weapons, Artifacts, Teammates, and Build</title>
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
            }
        <?php endforeach; ?>

        function displayImg(ingredient) {
            let key = "ingredient_img_" + ingredient;
            let imgData = localStorage.getItem(key);

            if (imgData) {
                document.write("<img src='data:image/*;base64," + imgData + "' alt='" + ingredient + "'>");
            } else {
                document.write("Image not found for " + ingredient);
            }
        };

        function displayDescription(ingredient) {
            let key = "ingredient_description_" + ingredient;
            let description = localStorage.getItem(key);
            if (description) {
                document.write(description);
            } else {
                document.write("Description not found for " + ingredient);
            }
        };
    </script>
</head>

<body onload="updateServings()">
    <div class="grid-container">
        <!--Header Start-->
        <div id="inc-header"></div>
        <script>
            $(function() {
                $("#inc-header").load("../structure/header.html")
            });
        </script>
        <!--Header End-->
        <!--Top Nav Start-->
        <div id="inc-top-nav"></div>
        <script>
            $(function() {
                $("#inc-top-nav").load("../structure/top_nav.html")
            });
        </script>
        <!--Top Nav End-->
        <!--Side Nav Start-->
        <div id="inc-side-nav"></div>
        <script>
            $(function() {
                $("#inc-side-nav").load("../structure/side_nav.html")
            });
        </script>
        <!--Side Nav End-->
        <!--Left Ad Start-->
        <div id="inc-left-ad">
            <div class="left-ad"><img src="/hoyomeals/img/icon/left-ad1.jpg" alt=""></div>
        </div>
        <!--Left Ad End-->
        <!--Content Area Start-->
        <main onclick="hideSideNav()">

            <!--Content Ad Head Start-->
            <div id="head-content-ad">
                <div class="content-ad"><img src="/hoyomeals/img/icon/ad1.png" alt="header_ad"></div>
            </div>

            <div class="disclaimerHeader">
                This is an academic site.
                <br>All recipes are fictional. DO NOT ATTEMPT!
            </div>
            <!-- End of site skeleton structure -->
<!--Content Ad Head End-->

            <!--Content Div Start-->
            <div class="main-content-div">

                <div class="recipeSelection_div">

                    <!--Parallelogram Title Start-->
                    <div class="parallelogram-title" id="colorTheme">
                        <h2 id="heading-0">Ingrediants</h2>
                    </div>
                  <?php  foreach ($recipes as $recipe) : ?>
                    <?php
                    $ingredientsData = json_decode($recipe['recipe_ingredients'], true);
                    if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
                        foreach ($ingredientsData['ingredients'] as $key => $ingredients) {
                            $ingredientName = $ingredients['name'];
                            $imageId = 'ingredientImg_' . $ingredientName;
                            echo '<div class="article">';
                            echo '<h3 id="heading-3">' . ucfirst($ingredients['name']) . ' x<span id="quantity_' . $key . '">' . $ingredients['quantity'] . '</span></h3>';
                            echo '<div class="content-article">';
                            echo '<div class="h3-block" id="colorTheme"></div>';
                            echo '<div class="content-text">';
                            echo '<div><script>displayImg("' . str_replace(' ', '_', ucfirst($ingredients['name'])) . '");</script>';
                            echo '<div><script>displayDescription("' . str_replace(' ', '_', ucfirst($ingredients['name'])) . '");</script>';
                            echo '</div></div></div>';
                        }
                    }
                    ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
        <!--Content Area End-->
        <!--Right Ad Start-->
        <div id="inc-right-ad">
            <div class="right-ad"><img src="/hoyomeals/img/icon/right-ad1.jpg" alt="right_ad"></div>
        </div> <!--Right Ad End-->
        <!--Footer Start-->
        <div id="inc-footer"></div>
        <script>
            $(function() {
                $("#inc-footer").load("/Hoyomeals/structure/footer.html")
            });
        </script>
        <!--Footer End-->
    </div>
    <!-- End of site skeleton structure -->
</body>


<div>
    
</div>


</html>