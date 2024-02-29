<?php
require 'dbConnect.php';

$sql = "SELECT recipe_servingSize, recipe_ingredients, recipe_prepTime, recipe_cookTime  FROM hoyomeals_recipes";
$stmt = $conn->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($recipes as $recipe) :
    $ingredients = json_decode($recipe['recipe_ingredients'], true);

    $totalTime = $recipe['recipe_prepTime'] + $recipe['recipe_cookTime'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script>
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

    <body onload="updateServings()">
        <table class="table2-info">
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
        </table>

        <?php
        $ingredientsData = json_decode($recipe['recipe_ingredients'], true);
        if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
            foreach ($ingredientsData['ingredients'] as $key => $ingredients) {
                $imageId = 'ingredientImg_' . $ingredients['name'];
                echo '<div class="article">';
                echo '<h3 id="heading-3">' . ucfirst($ingredients['name']) . ' x<span id="quantity_' . $key . '">' . $ingredients['quantity'] . '</span></h3>';
                echo '<div class="content-article">';
                echo '<div class="h3-block" id="colorTheme"></div>';
                echo '<div class="content-text">';
                echo '<img id="' . $imageId . '" class="article-icons" alt="">';
                echo '<script>displayIngredient(\'' . $ingredients['name'] . '\', \'' . $imageId . '\');</script>';
                echo $ingredients['description'];
                echo '</div></div></div>';
            }
        }
        ?>
    </body>
<?php endforeach; ?>

    </html>