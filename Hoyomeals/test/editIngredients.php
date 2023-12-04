<?php
session_start();

if (!isset($_SESSION['adminLoggedIn']) || $_SESSION['adminLoggedIn'] !== 'valid') {
    header('Location: login.php');
    exit();
};

$confirmMessage = false;

require '../dbConnect.php';

$sql = "SELECT ingredient_id, ingredient_name, ingredient_img, ingredient_description FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredient_id = $_POST['ingredient_id'];
    $new_ingredientName = !empty($_POST['ingredientNameModify']) ? $_POST['ingredientNameModify'] : (isset($ingredients[$ingredient_id]['ingredient_name']) ? $ingredients[$ingredient_id]['ingredient_name'] : '');
    $new_ingredientDescription = !empty($_POST['ingredientDescriptionModify']) ? $_POST['ingredientDescriptionModify'] : (isset($ingredients[$ingredient_id]['ingredient_description']) ? $ingredients[$ingredient_id]['ingredient_description'] : '');


    //Image Handling
    if (isset($_FILES["ingredientImgModify"]) && $_FILES["ingredientImgModify"]["error"] == 0) {
        $new_ingredientImg = file_get_contents($_FILES["ingredientImgModify"]["tmp_name"]);
    } else {
        $new_ingredientImg = $ingredients[$ingredient_id]['ingredient_img'];
    };

    $sql_update = "UPDATE hoyomeals_ingredients SET ingredient_name = :new_ingredientName, ingredient_img = :new_ingredientImg, ingredient_description = :new_ingredientDescription WHERE ingredient_id = :ingredient_id";
    $stmt_update = $conn->prepare($sql_update);

    $stmt_update->bindParam(':new_ingredientName', $new_ingredientName);
    $stmt_update->bindParam(':new_ingredientImg', $new_ingredientImg);
    $stmt_update->bindParam(':new_ingredientDescription', $new_ingredientDescription);
    $stmt_update->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_LOB);

    $stmt_update->execute();

    $confirmMessage = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/hoyomeals/css/styles.css" rel="stylesheet" type="text/css">
    <link href="/hoyomeals/css/stylesForm.css" rel="stylesheet" type="text/css">
    <!-- jquery is used for the .load function used to import the structure of the site from an external file. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="/hoyomeals/script/script.js"></script>

    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <style>

    </style>
</head>

<body>
    <!-- Start of site skeleton structure -->
    <div class="grid-container">
        <div id="inc-header"></div>
        <script>
            $(function() {
                $("#inc-header").load("/hoyomeals/structure/header.html")
            });
        </script>
        <div id="inc-top-nav"></div>
        <script>
            $(function() {
                $("#inc-top-nav").load("/hoyomeals/structure/top_nav.html")
            });
        </script>
        <div id="inc-side-nav"></div>
        <script>
            $(function() {
                $("#inc-side-nav").load("/hoyomeals/structure/side_nav.html")
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
                <div class="page-title">
                    <h1 style="text-align: center;">Edit Ingredients</h1>
                    TEXT
                </div>

                <?php
                if ($confirmMessage) {
                ?>
                    <div class="confirmMessage">
                        <h2>Thank you. We have Updated the Ingredient.</h2>
                    </div>
                <?php
                } else {
                ?>
                    <?php foreach ($ingredients as $ingredient) : ?>
                        <div class="ingredient_modify_grid">
                            <div class="ID grid_title gridBorder_top_left_right">ID</div>
                            <div class="Name grid_title gridBorder_top_right">Name</div>
                            <div class="Image grid_title gridBorder_top_right">Image</div>
                            <div class="Description grid_title gridBorder_top_right">Description</div>

                            <div class="id_data grid_content gridBorder_bottom_left_right"><?= $ingredient['ingredient_id'] ?></div>
                            <div class="name_data grid_content gridBorder_right"><?= $ingredient['ingredient_name'] ?></div>
                            <div class="image_data grid_content gridBorder_right"><img src="data:image/jpeg;base64,<?= base64_encode($ingredient['ingredient_img']) ?>" alt="Recipe Image"></div>
                            <div class="description_data grid_content gridBorder_right"><?= $ingredient['ingredient_description'] ?></div>

                            <form action="editIngredients.php" method="post" enctype="multipart/form-data" accept-charset="" onsubmit="return confirm('Are you sure you want to MODIFY this INGREDIENT on the database? THE CHANGES ARE IRREVERSABLE!');">
                                <div class="name_input grid_content gridBorder_bottom_right">
                                    <label for="ingredientNameModify"></label>
                                    <input type="text" name="ingredientNameModify" id="ingredientNameModify">
                                </div>

                                <div class="image_input grid_content gridBorder_bottom_right">
                                    <label for="ingredientImgModify"></label>
                                    <input type="file" id="ingredientImgModify" name="ingredientImgModify">
                                </div>

                                <div class="description_input grid_content gridBorder_bottom_right">
                                    <label for="ingredientDescriptionModify"></label>
                                    <textarea type="text" name="ingredientDescriptionModify" id="ingredientDescriptionModify"></textarea>
                                </div>

                                <div class="modify_button button_style">
                                    <input type="hidden" name="ingredient_id" value="<?= $ingredient['ingredient_id'] ?>">
                                    <button type="submit" style="color: green;">Modify Ingredient on Database</button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php
                }
                ?>
            </div>
        </main>
        <div id="inc-right-ad">
            <div class="right-ad"><img src="/hoyomeals/img/icon/right-ad1.jpg" alt="right_ad"></div>
        </div>
        <div id="inc-footer"></div>
        <script>
            $(function() {
                $("#inc-footer").load("/hoyomeals/structure/footer.html")
            });
        </script>
    </div>
    <!-- End of site skeleton structure -->
</body>

</html>