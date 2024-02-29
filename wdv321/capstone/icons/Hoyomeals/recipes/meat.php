<?php
require 'dbConnect.php';

$sql = "SELECT recipe_id, recipe_name, recipe_description, recipe_img, recipe_difficulty, recipe_prepTime, recipe_cookTime, recipe_servingSize, recipe_calories, recipe_allergy, recipe_ingredients, recipe_steps, recipe_authorName, recipe_authorEmail, recipe_dateModified, recipe_dateEntered FROM hoyomeals_recipes WHERE recipe_id=:recID";
$stmt = $conn->prepare($sql);
$recID = 1;
$stmt->bindParam(':recID', $recID);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($recipes as $recipe) :
    $allergy = json_decode($recipe['recipe_allergy'], true);
    $ingredients = json_decode($recipe['recipe_ingredients'], true);
    $steps = json_decode($recipe['recipe_steps'], true);

    $totalTime = $recipe['recipe_prepTime'] + $recipe['recipe_cookTime'];
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
            function displayIngredient(ingredientName, imageId) {
                if (ingredientName !== "") {
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            let imgData = xhr.responseText;
                            document.getElementById(imageId).src = "data:image/jpeg;base64," + imgData;
                        }
                    };
                    xhr.open("GET", "../php/getIngredient.php?ingredient_name=" + ingredientName, true);
                    xhr.send();
                }
            };

            function updateServings() {
                let selectedServings = document.querySelector('.servings_select').value;
                let servingSize = <?= $recipe['recipe_servingSize'] ?>;

                let yieldValue = servingSize * selectedServings;
                document.getElementById('yieldValue').innerText = yieldValue + ' oz';

                let ingredients = <?= json_encode($ingredients['ingredients']) ?>;
                ingredients.forEach((ingredient, index) => {
                    let newQuantity = ingredient.quantity * selectedServings;
                    document.getElementById('quantity_' + index).innerText = newQuantity;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.servings_select').addEventListener('change', updateServings);
            });
        </script>
    </head>

    <body onload="updateServings(), socializerLoad()">
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
                <div class="left-ad"></div>
            </div>
            <!--Left Ad End-->
            <!--Content Area Start-->
            <main onclick="hideSideNav()">

                <!--Content Ad Head Start-->
                <div id="head-content-ad">
                    <div class="content-ad"></div>
                </div><!--Content Ad Head End-->

                <!--Content Div Start-->
                <div class="main-content-div">

                    <div style="margin-bottom: 15px;"><a href="../hoyomeals/index.html">Hoyomeals</a> > <a onclick="showRecipeGallery()">Meat</a> > Outrider</div>

                    <div class="recipeSelection_div">
                        <!--Page Title Start-->
                        <div class="page-title">
                            <!--Title Here-->
                            <h1 style="text-align: center;">Meats</h1>
                            <!--Text Here-->
                        </div>
                        <!--Page Title End-->

                        <!--Parallelogram Title Start-->
                        <div class="parallelogram-title" id="colorTheme">
                            <h2>Trouble deciding? <a href="#">Have a random recipe!</a> </h2>
                        </div>
                        <!--Parallelogram Title End-->

                        <div class="recipeGallery">
                            <figure>
                                <img src="../img/food/i_1003_4.webp" alt="alt_text" onclick="showRecipe()">
                                <figcaption>Meat</figcaption>
                            </figure>
                        </div>
                    </div>

                    <script>
                        function showRecipe() {
                            let recipeSelectionDiv = document.querySelector('.recipeSelection_div');
                            let recipeDiv = document.querySelector('.recipe_div');

                            if (recipeSelectionDiv && recipeDiv) {
                                recipeSelectionDiv.style.display = 'none';
                                recipeDiv.style.display = 'block';
                            }
                        }
                    </script>

                    <script>
                        function showRecipeGallery() {
                            let recipeSelectionDiv = document.querySelector('.recipeSelection_div');
                            let recipeDiv = document.querySelector('.recipe_div');

                            if (recipeSelectionDiv && recipeDiv) {
                                recipeSelectionDiv.style.display = 'block';
                                recipeDiv.style.display = 'none';
                            }
                        }
                    </script>

                    <div class="recipe_div">
                        <!--Content Header Start-->
                        <div class="content-header">

                            <!--Page Title Start-->
                            <div class="page-title-article">
                                <!--Title Here-->
                                <h1><?= $recipe['recipe_name'] ?></h1>
                                <em class="opening-quote"><?= $recipe['recipe_description'] ?></em>
                            </div>
                            <!--Page Title End-->

                            <!--InfoBox Start-->
                            <div class="info-box">
                                <!--Header Table Start-->
                                <table class="table1-info">
                                    <tr>
                                        <td class="info-box-title" id="colorTheme"><?= $recipe['recipe_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-img"><img src="data:image/jpeg;base64,<?= base64_encode($recipe['recipe_img']) ?>" alt="Recipe Image">
                                        </td>
                                    </tr>
                                </table>

                                <table class="table2-info">
                                    <tr>
                                        <td class="info-box-label">Difficulty</td>
                                        <td class="info-box-value">
                                            <?php
                                            $difficulty = $recipe['recipe_difficulty'];
                                            for ($i = 0; $i < $difficulty; $i++) {
                                                echo '<img src="../img/icon/difficulty_star.webp" class="icon_drop_shadow" alt="alt_text">';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label info-box_thick-border">Total Time:</td>
                                        <td class="info-box-value info-box_thick-border"><?php echo $totalTime ?> min</td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Prep Time:</td>
                                        <td class="info-box-value"><?= $recipe['recipe_prepTime'] ?> min</td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Cook Time:</td>
                                        <td class="info-box-value"><?= $recipe['recipe_cookTime'] ?> min</td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label info-box_thick-border">Serving Size:</td>
                                        <td class="info-box-value info-box_thick-border"><?= $recipe['recipe_servingSize'] ?> oz</td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Servings:</td>
                                        <td class="info-box-value"><select class="servings_select">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Yield</td>
                                        <td class="info-box-value" id="yieldValue"> oz</td>
                                    </tr>
                                    <tr style="line-height: normal;">
                                        <td class="info-box-label info-box_thick-border">Calories <br><span class="per-serving_change">(per serving)</span></td>
                                        <td class="info-box-value info-box_thick-border"><?= $recipe['recipe_calories'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Allergies</td>
                                        <td class="info-box-value">
                                            <?php
                                            $allergyData = json_decode($recipe['recipe_allergy'], true);
                                            if (isset($allergyData['allergies']) && is_array($allergyData['allergies'])) {
                                                foreach ($allergyData['allergies'] as $allergy) {
                                                    echo ucfirst($allergy) . '<br>';
                                                }
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label info-box_thick-border">Author</td>
                                        <td class="info-box-value info-box_thick-border"><?= $recipe['recipe_authorName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="info-box-label">Published</td>
                                        <td class="info-box-value"><?= $recipe['recipe_dateEntered'] ?></td>
                                    </tr>
                                </table>

                                <table class="table3-info">
                                    <tr>
                                        <td class="share-label">
                                            Share</td>
                                        <td class="share-value">
                                            <div class="socializer" data-features="32px,opacity,icon-dark,bg-none,pad" data-sites="facebook,twitter,reddit,email"></div>
                                        </td>
                                    </tr>
                                </table>

                                <div class="table-of-content">
                                    <table class="table1-table" id="colorTheme">
                                        <tbody>
                                            <tr>
                                                <td class="toc-title">Table of Content</td>
                                                <td class="toc-arrow"><img src="../img/icon/table_arrow.png" alt="Dropdown arrow for the Table of Contents" onclick="tocDropdown()" class="toc-arrow"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="toc-dropdown" class="toc-dropdown-content">
                                        <ol>
                                            <li class="toc-h2"><a href="#heading-0">Materials</a>
                                            <li class="toc-h3"><a href="#heading-1">Common Drop</a></li>
                                            </li>
                                            <li class="toc-h2"><a href="#heading-5">Talents</a>
                                            <li class="toc-h3"><a href="#heading-6">Normal Attack</a></li>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <!--Table of Content End-->
                            </div>
                            <!--InfoBox End-->
                        </div>
                        <!--Content Header End-->

                        <!--Parallelogram Title Start-->
                        <div class="parallelogram-title" id="colorTheme">
                            <h2 id="heading-0">Ingrediants</h2>
                        </div>

                        <?php
                        $ingredientsData = json_decode($recipe['recipe_ingredients'], true);
                        if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
                            $ingredientNumber = 1;
                            foreach ($ingredientsData['ingredients'] as $key => $ingredients) {
                                $imageId = 'ingredientImg_' . $ingredients['name'];
                                echo '<div class="article">';

                                $class = ($ingredientNumber == 1) ? 'first-h3' : '';
                                echo '<h3 id="heading-3" class="' . $class . '">' . ucfirst($ingredients['name']) . ' x<span id="quantity_' . $key . '">' . $ingredients['quantity'] . '</span></h3>';
                                echo '<div class="content-article">';
                                echo '<div class="h3-block" id="colorTheme"></div>';
                                echo '<div class="content-text">';
                                echo '<img id="' . $imageId . '" class="article-icons" alt="">';
                                echo '<script>displayIngredient(\'' . $ingredients['name'] . '\', \'' . $imageId . '\');</script>';
                                echo $ingredients['description'];
                                echo '</div></div></div>';

                                $ingredientNumber++;
                            }
                        }
                        ?>

                        <!--Article ad 1 Start-->
                        <div id="article-ad-one">

                        </div> <!--Article ad 1 End-->

                        <!--Parallelogram Title Start-->
                        <div class="parallelogram-title" id="colorTheme">
                            <h2 id="heading-5">Directions</h2>
                        </div>
                        <!--Parallelogram Title End-->

                        <?php
                        $stepsData = json_decode($recipe['recipe_steps'], true);
                        if (isset($stepsData['steps']) && is_array($stepsData['steps'])) {
                            $stepNumber = 1;
                            foreach ($stepsData['steps'] as $steps) {
                                echo '<div class="article">';

                                $class = ($stepNumber == 1) ? 'first-h3' : '';

                                echo '<h3 id="heading-6" class="' . $class . '">Step ' . $stepNumber . ': ' . ucfirst($steps['title']) . '</h3>';
                                echo '<div class="content-article">';
                                echo '<div class="h3-block" id="colorTheme"></div>';
                                echo '<div class="content-text">' . ucfirst($steps['description']) . '</div>';
                                echo '</div></div>';

                                $stepNumber++;
                            }
                        }
                        ?>


                        <!--Reciept Div End-->
                    </div>

                    <!--Content Div End-->
                    <!--Content Ad Tail Start-->
                    <div id="tail-content-ad">
                        <div class="content-ad"></div>
                    </div><!--Content Ad Tail End-->
                </div>
            </main>
            <!--Content Area End-->
            <!--Right Ad Start-->
            <div id="inc-right-ad">
                <div class="right-ad"></div>
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
    </body>
<?php endforeach; ?>

    </html>