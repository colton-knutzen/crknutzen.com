<?php
require 'dbConnect.php';

$sql = "SELECT recipe_categoryTemp, recipe_nameTemp, recipe_descriptionTemp, recipe_imgTemp, recipe_difficultyTemp, recipe_prepTimeTemp, recipe_cookTimeTemp, recipe_servingSizeTemp, recipe_caloriesTemp, recipe_allergyTemp, recipe_ingredientsTemp, recipe_stepsTemp, recipe_authorNameTemp, recipe_authorEmailTemp, recipe_dateModifiedTemp, recipe_dateEnteredTemp FROM hoyomeals_recipes_temp";
$stmt = $conn->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($recipes as $recipe) :

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TABLE</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>

    <body>

        <table>
            <tbody>
                <tr>
                    <td><?= $recipe['recipe_idTemp'] ?></td>
                    <td><?= $recipe['recipe_categoryTemp'] ?></td>
                    <td><?= $recipe['recipe_nameTemp'] ?></td>
                    <td><?= $recipe['recipe_descriptionTemp'] ?></td>
                    <td><img src="data:image/jpeg;base64,<?= base64_encode($recipe['recipe_imgTemp']) ?>" alt="Recipe Image" style="max-width: 100px; max-height: 100px;"></td>
                    <td><?= $recipe['recipe_difficultyTemp'] ?></td>
                    <td><?= $recipe['recipe_prepTimeTemp'] ?></td>
                    <td><?= $recipe['recipe_cookTimeTemp'] ?></td>
                    <td><?= $recipe['recipe_servingSizeTemp'] ?></td>
                    <td><?= $recipe['recipe_caloriesTemp'] ?></td>
                    <td><?php
                        $allergyData = json_decode($recipe['recipe_allergyTemp'], true);
                        if (isset($allergyData['allergies']) && is_array($allergyData['allergies'])) {
                            foreach ($allergyData['allergies'] as $allergy) {
                                echo $allergy . '<br>';
                            }
                        }
                        ?></td>
                        <td>
                        <?php
                        // Decode JSON and access individual ingredients
                        $ingredientsData = json_decode($recipe['recipe_ingredientsTemp'], true);
                        if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
                            foreach ($ingredientsData['ingredients'] as $ingredients) {
                                echo 'Name: ' . $ingredients['name'] . '<br>';
                                echo 'Quantity: ' . $ingredients['quantity'] . '<br>';
                                echo '<br>'; // Add a line break between ingredients
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Decode JSON and access individual ingredients
                        $stepsData = json_decode($recipe['recipe_stepsTemp'], true);
                        if (isset($stepsData['steps']) && is_array($stepsData['steps'])) {
                            foreach ($stepsData['steps'] as $steps) {
                                echo 'Title: ' . $steps['title'] . '<br>';
                                echo 'Description: ' . $steps['description'] . '<br>';
                                echo '<br>'; // Add a line break between ingredients
                            }
                        }
                        ?>
                    </td>
                    <td><?= $recipe['recipe_authorNameTemp'] ?></td>
                    <td><?= $recipe['recipe_authorEmailTemp'] ?></td>
                    <td><?= $recipe['recipe_dateModifiedTemp'] ?></td>
                    <td><?= $recipe['recipe_dateEnteredTemp'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </body>

    </html>