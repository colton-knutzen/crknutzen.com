<?php
$confirmMessage = false;

require 'dbConnect.php';

$sql = "SELECT ingredient_id, ingredient_name, ingredient_img, ingredient_description FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredient_id = $_POST['ingredient_id'];

    $sql_delete = "DELETE FROM hoyomeals_ingredients WHERE ingredient_id = :ingredient_id";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':ingredient_id', $ingredient_id);
    $stmt_delete->execute();

    $confirmMessage = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="script/script.js"></script>

    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <style>

    </style>

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
                    <h1 style="text-align: center;">Revise Ingredients</h1>
                    TEXT
                </div>

                <?php
                if ($confirmMessage) {
                ?>
                    <div class="confirmMessage">
                        <h2>Thank you. We have input your information.</h2>
                    </div>
                <?php
                } else {
                ?>
                    <?php foreach ($ingredients as $ingredient) : ?>
                        <div class="ingredient_revise_grid">
                            <div class="ID grid_title gridBorder_top_left_right">ID</div>
                            <div class="Name grid_title gridBorder_top_right">Name</div>
                            <div class="Image grid_title gridBorder_top_right">Image</div>
                            <div class="Description grid_title gridBorder_top_right">Description</div>
                            <div class="id_data grid_content gridBorder_bottom_left_right"><?= $ingredient['ingredient_id'] ?></div>
                            <div class="name_data grid_content gridBorder_bottom_right"><?= $ingredient['ingredient_name'] ?></div>
                            <div class="image_data grid_content gridBorder_bottom_right"><img src="data:image/jpeg;base64,<?= base64_encode($ingredient['ingredient_img']) ?>" alt="Recipe Image"></div>
                            <div class="description_data grid_content gridBorder_bottom_right"><?= $ingredient['ingredient_description'] ?></div>

                            <div class="delete_button button_style">
                                <form action="reviseIngredientsForm.php" method="post" onsubmit="return confirm('Are you sure you want to DELETE this INGREDIENT from the database? IT WILL BE GONE FOREVER');">
                                    <input type="hidden" name="ingredient_id" value="<?= $ingredient['ingredient_id'] ?>">
                                    <button type="submit" style="color: red;">Delete from Ingredient Database</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php
                }
                ?>
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