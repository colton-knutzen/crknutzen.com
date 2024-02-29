<?php
$confirmMessage = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve recipe ID from the hidden input field
    $recipe_id = $_POST['recipe_id'];

    require '../dbConnect.php';

    $sql_delete = "DELETE FROM hoyomeals_recipes_temp WHERE recipe_idTemp = :recipe_id";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':recipe_id', $recipe_id);
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
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
    <link href="../css/stylesForm.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../script/script.js"></script>

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

                <?php if ($confirmMessage) { ?>
                    <div>
                        <h2>Thank you. We have input your information.</h2>
                        <button><a href="../tempReviseForm copy.php">Return to Revise Page</a></button>
                    </div>
                <?php } else { ?>
                    <div>
                        <h2>Something went wrong. Recipe was not deleted from the database</h2>
                        <button><a href="../tempReviseForm copy.php">Return to Revise Page</a></button>
                    </div>
                <?php } ?>
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