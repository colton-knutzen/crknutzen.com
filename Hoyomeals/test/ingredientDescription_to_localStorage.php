<?php
require '../dbConnect.php';

$sqlIngredient = "SELECT ingredient_name, ingredient_description FROM hoyomeals_ingredients";
$stmtIngredient = $conn->prepare($sqlIngredient);
$stmtIngredient->execute();
$ingredients = $stmtIngredient->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>

        let ingredientDescription = "";

       <?php foreach ($ingredients as $ingredient): ?>
            ingredientDescription = <?php echo json_encode($ingredient['ingredient_description']); ?>;
            localStorage.setItem("ingredient_description_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>", ingredientDescription);
            console.log(localStorage.getItem("ingredient_description_<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>"));
        <?php endforeach; ?>

        function displayDescription(ingredient) {
            let key = "ingredient_description_" + ingredient;
            let description = localStorage.getItem(key);
            if (description) {
                document.write(description);
            } else {
                document.write("Description not found for " + ingredient);
            }
        }
    </script>
</head>

<body>
    <div>
    <script>displayDescription("<?php echo str_replace(' ', '_', $ingredient['ingredient_name']); ?>")</script>
    </div>

</body>

</html>
