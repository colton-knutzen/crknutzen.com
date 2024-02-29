<?php
require 'dbConnect.php';

$sql = "SELECT recipe_idTemp, recipe_categoryTemp, recipe_nameTemp, recipe_descriptionTemp, recipe_imgTemp, recipe_difficultyTemp, recipe_prepTimeTemp, recipe_cookTimeTemp, recipe_servingSizeTemp, recipe_caloriesTemp, recipe_allergyTemp, recipe_ingredientsTemp, recipe_stepsTemp, recipe_authorNameTemp, recipe_authorEmailTemp, recipe_dateModifiedTemp, recipe_dateEnteredTemp FROM hoyomeals_recipes_temp";
$stmt = $conn->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/stylesForm.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="script/script.js"></script>

    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>

<body onload="socializerLoad()">
    <div class="grid-container">
        <!--Header Start-->
        <div id="inc-header"></div>
        <script>
            $(function() {
                $("#inc-header").load("structure/header.html")
            });
        </script>
        <!--Header End-->
        <!--Top Nav Start-->
        <div id="inc-top-nav"></div>
        <script>
            $(function() {
                $("#inc-top-nav").load("structure/top_nav.html")
            });
        </script>
        <!--Top Nav End-->
        <!--Side Nav Start-->
        <div id="inc-side-nav"></div>
        <script>
            $(function() {
                $("#inc-side-nav").load("structure/side_nav.html")
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

                <!--Page Title Start-->
                <div class="page-title">
                    <!--Title Here-->
                    <h1 style="text-align: center;">Revise User submitted recipes</h1>
                    TEXT
                </div>
                <!--Page Title End-->
                <?php foreach ($recipes as $recipe) : ?>
                    <div class="revise_user_submitted_recipes">
                        <div class="ID grid_title gridBorder_top_left_right">ID</div>
                        <div class="id_data grid_content gridBorder_left_right"><?= $recipe['recipe_idTemp'] ?></div>
                        <div class="Date-Entered grid_title gridBorder_top_left_right">Date Entered</div>
                        <div class="date_entered_data grid_content gridBorder_left_right"><?= $recipe['recipe_dateEnteredTemp'] ?></div>
                        <div class="Date-Modified grid_title gridBorder_top_left_right"> Date Modified</div>
                        <div class="date_modified_data grid_content gridBorder_left_right"><?= $recipe['recipe_dateModifiedTemp'] ?></div>
                        <div class="Author-Name grid_title gridBorder_top_left_right">Author Name</div>
                        <div class="author_name_data grid_content gridBorder_left_right"><?= $recipe['recipe_authorNameTemp'] ?></div>
                        <div class="Author-Email grid_title gridBorder_top_left_right">Author Email</div>
                        <div class="author_email_data grid_content gridBorder_left_right"><?= $recipe['recipe_authorEmailTemp'] ?></div>
                        <div class="Allergies grid_title gridBorder_right">Allergies</div>
                        <div class="allergies_data grid_content gridBorder_bottom_right">
                            <?php
                            $allergyData = json_decode($recipe['recipe_allergyTemp'], true);
                            if (isset($allergyData['allergies']) && is_array($allergyData['allergies'])) {
                                foreach ($allergyData['allergies'] as $allergy) {
                                    echo $allergy . '<br>';
                                }
                            }
                            ?></div>
                        <div class="Category grid_title gridBorder_top_right">Category</div>
                        <div class="category_data grid_content gridBorder_right"><?= $recipe['recipe_categoryTemp'] ?></div>
                        <div class="Name grid_title gridBorder_top_right">Recipe Name</div>
                        <div class="name_data grid_content gridBorder_right"><?= $recipe['recipe_nameTemp'] ?></div>
                        <div class="Description grid_title gridBorder_top_right">Description</div>
                        <div class="description_data grid_content gridBorder_bottom_right"><?= $recipe['recipe_descriptionTemp'] ?></div>
                        <div class="recipe_img grid_content gridBorder_top_right_bottom"><img src="data:image/jpeg;base64,<?= base64_encode($recipe['recipe_imgTemp']) ?>" alt="Recipe Image" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="Difficulty grid_title">Difficulty</div>
                        <div class="difficulty_data grid_content "><?= $recipe['recipe_difficultyTemp'] ?></div>
                        <div class="Serving-Size grid_title gridBorder_right">Serving Size</div>
                        <div class="serving_size_data grid_content gridBorder_bottom_right"><?= $recipe['recipe_servingSizeTemp'] ?></div>
                        <div class="Prep-Time grid_title gridBorder_right">Prep Time</div>
                        <div class="prep_time_data grid_content gridBorder_bottom_right"><?= $recipe['recipe_prepTimeTemp'] ?></div>
                        <div class="Cook-Time grid_title gridBorder_right">Cook Time</div>
                        <div class="cook_time_data grid_content gridBorder_bottom_right"><?= $recipe['recipe_cookTimeTemp'] ?></div>
                        <div class="Calories grid_title gridBorder_right">Calories</div>
                        <div class="calories_data grid_content gridBorder_right_left"><?= $recipe['recipe_caloriesTemp'] ?></div>

                        <div class="Ingredients grid_title gridBorder_top_left_right">Ingredients</div>
                        <div class="ingredients_data gridBorder_bottom_left_right">
                            <table>
                                <?php
                                $ingredientsData = json_decode($recipe['recipe_ingredientsTemp'], true);
                                if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
                                    foreach ($ingredientsData['ingredients'] as $ingredients) {
                                        echo '<tr class="tr_bottom_border">';
                                        echo '<td><img src="img/ingrediants/i_615.webp" alt=""></td>';
                                        echo '<td>' . $ingredients['name'] . '</td>';
                                        echo '<td>x' . $ingredients['quantity'] . '</td>';
                                        echo '</tr>';
                                    }
                                } ?>
                            </table>
                        </div>
                        <div class="Steps grid_title gridBorder_top_right">Steps</div>
                        <div class="step_data gridBorder_bottom_right">
                            <table>
                                <?php
                                $stepsData = json_decode($recipe['recipe_stepsTemp'], true);
                                if (isset($stepsData['steps']) && is_array($stepsData['steps'])) {
                                    foreach ($stepsData['steps'] as $steps) {
                                        echo '<tr class="tr_bottom_border">';
                                        echo '<td>Step 1</td>';
                                        echo '<td>' . $steps['title'] . '</td>';
                                        echo '<td>' . $steps['description'] . '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </table>
                        </div>

                        <div class="commit_button button_style"><button style="color: green;">Commit to Main
                                Database</button></div>
                        <div class="delete_button button_style"><button style="color: red;">Delete from Temporary
                                Database</button></div>
                    </div>

                    <div id="tail-content-ad">
                        <div class="content-ad"></div>
                    </div>
                <?php endforeach; ?>
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
                $("#inc-footer").load("structure/footer.html")
            });
        </script>
        <!--Footer End-->
    </div>
</body>

</html>