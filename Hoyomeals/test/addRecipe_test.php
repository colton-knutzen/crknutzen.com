<?php
require '../dbConnect.php';

$sql = "SELECT ingredient_name FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$confirmMessage = false;

if (isset($_POST['submit'])) {

    $event_location = $_POST['event_location']; // Honeypot
    if (empty($event_location)) {

        $inCategory = $_POST['recipeCategory'];
        $inRecipeName = $_POST['recipeName'];
        $inDescription = $_POST['recipeDescription'];
        $inDifficulty = $_POST['difficultyRating'];
        $inPrepTime = $_POST['prepTime'];
        $inCookTime = $_POST['cookTime'];
        $inServingSize = $_POST['servingSize'];
        $inCalories = $_POST['calories'];
        $inAuthorFirstName = $_POST['firstName'];
        $inAuthorLastName = $_POST['lastName'];
        $inAuthorName = $inAuthorFirstName . ' ' . $inAuthorLastName;
        $inAuthorEmail = $_POST['email'];

        // Cooking Steps handling
        $recipeSteps = [];
        if (isset($_POST['recipeSteps'])) {
            $stepTitles = $_POST['recipeSteps'];
            $stepDescriptions = $_POST['recipeDescriptions'];

            // Iterate through the provided steps
            foreach ($stepTitles as $index => $stepTitle) {
                $stepDescription = $stepDescriptions[$index];

                // Check if both title and description are provided
                if (!empty($stepTitle) && !empty($stepDescription)) {
                    $recipeSteps[] = [
                        "title" => $stepTitle,
                        "description" => $stepDescription
                    ];
                }
            }
        }
        $stepsJSON = json_encode(['steps' => $recipeSteps]);

        //Ingredient handling
        $recipeIngredients = [];
        for ($i = 0; $i < count($_POST['ingredient']); $i++) {
            $ingredientName = $_POST['ingredient'][$i];
            $quantity = (int)$_POST['quantity'][$i]; // Cast to integer

            // Check if both ingredient and quantity are provided
            if (!empty($ingredientName) && is_numeric($quantity)) {
                $recipeIngredients[] = [
                    "name" => $ingredientName,
                    "quantity" => $quantity
                ];
            }
        }
        $ingredientsJSON = json_encode(['ingredients' => $recipeIngredients]);


        //Allergy handling
        $allergies = [];
        foreach ($_POST['allergy'] as $allergyInput) {
            if (!empty($allergyInput)) {
                $allergies[] = $allergyInput;
            }
        }
        $allergiesJSON = json_encode(['allergies' => $allergies]);


        //Image handling
        if (isset($_FILES["recipeImage"]) && $_FILES["recipeImage"]["error"] == 0) {
            $imageContent = file_get_contents($_FILES["recipeImage"]["tmp_name"]);
        } else {
            echo "<div class='confirmMessage'>
                    <h2>Please select a valid image file (WebP format).</h2>
                  </div>";
            exit;
        }

        $sql = "INSERT INTO hoyomeals_recipes_temp";
        $sql .= "(recipe_categoryTemp, recipe_nameTemp, recipe_descriptionTemp, recipe_imgTemp, recipe_difficultyTemp, recipe_prepTimeTemp, recipe_cookTimeTemp, recipe_servingSizeTemp, recipe_caloriesTemp, recipe_allergyTemp, recipe_ingredientsTemp, recipe_stepsTemp, recipe_authorNameTemp, recipe_authorEmailTemp, recipe_dateModifiedTemp, recipe_dateEnteredTemp)";
        $sql .= " VALUES ";
        $sql .= "(:category, :recipeName, :description, :imageContent, :difficulty, :prepTime, :cookTime, :servingSize, :calories, :allergies, :ingredients, :steps, :authorName, :authorEmail, :dateModified, :dateEntered)";

        $stmt = $conn->prepare($sql);

        $today = date("Y-m-d");

        $stmt->bindParam(':category', $inCategory);
        $stmt->bindParam(':recipeName', $inRecipeName);
        $stmt->bindParam(':description', $inDescription);
        $stmt->bindParam(':difficulty', $inDifficulty);
        $stmt->bindParam(':prepTime', $inPrepTime);
        $stmt->bindParam(':cookTime', $inCookTime);
        $stmt->bindParam(':servingSize', $inServingSize);
        $stmt->bindParam(':calories', $inCalories);
        $stmt->bindParam(':allergies', $allergiesJSON);
        $stmt->bindParam(':ingredients', $ingredientsJSON);
        $stmt->bindParam(':steps', $stepsJSON);
        $stmt->bindParam(':authorName', $inAuthorName);
        $stmt->bindParam(':authorEmail', $inAuthorEmail);
        $stmt->bindParam(':dateModified', $today);
        $stmt->bindParam(':dateEntered', $today);
        $stmt->bindParam(':imageContent', $imageContent, PDO::PARAM_LOB);

        $stmt->execute();

        $confirmMessage = true;
    } else {
        echo    "<div class='confirmMessage'>
                    <h2>We're sorry, there was an error. Please try submitting again.</h2>
                </div>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM</title>
    <style>
        .event_location {
            display: none;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>
    <script>
        function setRating(rating) {
            const stars = document.querySelectorAll('.star');
            for (let i = 0; i < stars.length; i++) {
                if (i < rating) {
                    stars[i].classList.add('selected');
                } else {
                    stars[i].classList.remove('selected');
                }
            }
            document.querySelector('#difficultyRating').value = rating;
            console.log(document.querySelector('#difficultyRating').value = rating);
        }
    </script>
</head>

<body onload="setRating()">
    <?php
    if ($confirmMessage) {
    ?>
        <div class="confirmMessage">
            <h2>Thank you. We have input your information.</h2>
        </div>
    <?php
    } else {
    ?>
        <form method="post" action="addRecipe_test.php" enctype="multipart/form-data" accept-charset="">
            <p>
                <label for="recipeStep">RECIPE STEPS*: TITLE & DESCRIPTION</label>
                <label for="recipeDescription"></label>
                <input type="text" name="recipeSteps[]" placeholder="Title">
                <textarea name="recipeDescriptions[]" placeholder="Description"></textarea>
            </p>

            <p>
                <label for="ingredient">INGREDIENTS* (For 1 Serving)</label>
                <label for="quantity"></label>
                <select name="ingredient[]">
                    <option value="">Select an Ingredient</option>
                    <?php
                    foreach ($ingredients as $ingredient) {
                        echo "<option value='{$ingredient['ingredient_name']}'>{$ingredient['ingredient_name']}</option>";
                    } ?>
                </select>
                <input type="number" name="quantity[]" placeholder="Qt">
            </p>

            <p>
                <label for="allergy">ALLERGIES*</label>
                <input type="text" name="allergy[]" placeholder="Peanuts">
            </p>

            <p>
                <label for="firstName">FIRST NAME/USERNAME*</label>
                <input type="text" id="firstName" name="firstName" placeholder="First Name">
            </p>

            <p>
                <label for="lastName">LAST NAME</label>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name">
            </p>

            <p>
                <label for="email">EMAIL*</label>
                <input type="email" id="email" name="email" placeholder="YourEmail@gmail.com">
            </p>

            <p>
                <label for="recipeImage">RECIPE IMAGE*</label>
                <input type="file" id="recipeImage" name="recipeImage" accept="image/*">
            </p>

            <p>
                <label for="difficultyRating" class="difficultyRating-label">DIFFICULTY*</label>
            <div class="difficultyRating">
                <span class="star" onclick="setRating(1)">★</span>
                <span class="star" onclick="setRating(2)">★</span>
                <span class="star" onclick="setRating(3)">★</span>
                <span class="star" onclick="setRating(4)">★</span>
            </div>
            <input type="hidden" id="difficultyRating" name="difficultyRating" value="0">
            </p>

            <p>
                <label for="recipeName">RECIPE NAME*</label>
                <input type="text" id="recipeName" name="recipeName" placeholder="Outrider's Champion Steak!">
            </p>

            <p>
                <label for="recipeCategory">RECIPE CATEGORY*</label>
                <select type="text" id="recipeCategory" name="recipeCategory">
                    <option value="">Select a Category</option>
                    <option value="appetizer">Appetizer</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="dessert">Dessert</option>
                    <option value="drink">Drink</option>
                    <option value="meat">Meat</option>
                    <option value="pasta">Pasta</option>
                    <option value="pizza">Pizza</option>
                    <option value="salad">Salad</option>
                    <option value="seafood">Seafood</option>
                    <option value="soup">Soup</option>
                </select>
            </p>

            <p>
                <label for="recipeDescription">RECIPE DESCRIPTION*</label>
                <textarea name="recipeDescription" id="recipeDescription" placeholder='"One side is obviously uncooked. The other side gives off a subtle scent of something burnt. Close your eyes and have a big mouthful, just to keep Amber happy if nothing else."'></textarea>
            </p>

            <p>
                <label for="firprepTimestName">TOTAL PREP TIME* (in minutes)</label>
                <input type="number" id="prepTime" name="prepTime" placeholder="20">
            </p>

            <p>
                <label for="cookTime">TOTAL COOK TIME* (in minutes)</label>
                <input type="number" id="cookTime" name="cookTime" placeholder="45">
            </p>

            <p>
                <label for="servingSize">SERVING SIZE* (in ounces)</label>
                <input type="number" id="servingSize" name="servingSize" placeholder="6">
            </p>

            <p>
                <label for="calories">CALORIES* (per serving)</label>
                <input type="number" id="calories" name="calories" placeholder="425">
            </p>

            <p class="event_location">
                <label for="event_location">HONEYPOT</label>
                <input type="text" name="event_location" id="event_location">
            </p>

            <p>
                <input style="color: green;" type="submit" name='submit' value="Submit">
                <input style="color: red;" type="reset" value="Reset">
            </p>
        </form>
        <?php
    }
        ?>
</body>

</html>