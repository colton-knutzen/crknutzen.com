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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
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
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Difficulty</th>
                <th>Prep Time</th>
                <th>Cook Time</th>
                <th>Serving Size</th>
                <th>Calories</th>
                <th>Allergy</th>
                <th>Ingredients</th>
                <th>Steps</th>
                <th>Author Name</th>
                <th>Author Email</th>
                <th>Date Modified</th>
                <th>Date Entered</th>
            </tr>
        </thead>
        <tbody>
            
                <tr>
                    <td></td>
                    <td><?= $recipe['recipe_name'] ?></td>
                    <td><?= $recipe['recipe_description'] ?></td>
                    <td><img src="data:image/jpeg;base64,<?= base64_encode($recipe['recipe_img']) ?>" alt="Recipe Image" style="max-width: 100px; max-height: 100px;"></td>
                    <td><?= $recipe['recipe_difficulty'] ?></td>
                    <td><?= $recipe['recipe_prepTime'] ?></td>
                    <td><?= $recipe['recipe_cookTime'] ?></td>
                    <td><?= $recipe['recipe_servingSize'] ?></td>
                    <td><?= $recipe['recipe_calories'] ?></td>
                    <td>
                        <?php
                        // Decode JSON and access individual elements
                        $allergyData = json_decode($recipe['recipe_allergy'], true);
                        if (isset($allergyData['allergies']) && is_array($allergyData['allergies'])) {
                            foreach ($allergyData['allergies'] as $allergy) {
                                echo $allergy . '<br>';
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Decode JSON and access individual ingredients
                        $ingredientsData = json_decode($recipe['recipe_ingredients'], true);
                        if (isset($ingredientsData['ingredients']) && is_array($ingredientsData['ingredients'])) {
                            foreach ($ingredientsData['ingredients'] as $ingredients) {
                                echo 'Name: ' . $ingredients['name'] . '<br>';
                                echo 'Description: ' . $ingredients['description'] . '<br>';
                                echo 'Quantity: ' . $ingredients['quantity'] . '<br>';
                                echo '<br>'; // Add a line break between ingredients
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Decode JSON and access individual ingredients
                        $stepsData = json_decode($recipe['recipe_steps'], true);
                        if (isset($stepsData['steps']) && is_array($stepsData['steps'])) {
                            foreach ($stepsData['steps'] as $steps) {
                                echo 'Title: ' . $steps['title'] . '<br>';
                                echo 'Description: ' . $steps['description'] . '<br>';
                                echo '<br>'; // Add a line break between ingredients
                            }
                        }
                        ?>
                    </td>
                    <td><?= $recipe['recipe_authorName'] ?></td>
                    <td><?= $recipe['recipe_authorEmail'] ?></td>
                    <td><?= $recipe['recipe_dateModified'] ?></td>
                    <td><?= $recipe['recipe_dateEntered'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>