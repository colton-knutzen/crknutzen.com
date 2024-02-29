<?php
require 'dbConnect.php';

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/stylesForm.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="script/script.js"></script>

    <style>
        /* HONEYPOT */
        .event_location {
            display: none;
        }
    </style>

    <title>!TITLE!</title>
    <meta name="keywords" content="!KEYWORDS!">
    <meta name="description" content="!DESCRIPTION!">
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
        }

        function addAllergy() {
            //Adds 1 to each new ID
            const allergyContainer = document.querySelector('#allergy_container');

            const existingAllergyInputs = allergyContainer.querySelectorAll('[id^="allergy_"]');
            const allergyCount = existingAllergyInputs.length + 1;

            const newAllergyFormRowDiv = document.createElement("div");
            newAllergyFormRowDiv.classList.add("form_row");
            newAllergyFormRowDiv.style.paddingBottom = "0px";

            const newAllergyDiv = document.createElement("div");
            newAllergyDiv.classList.add("one_column");

            // Create new label element
            const newAllergyLabel = document.createElement("label");
            newAllergyLabel.htmlFor = "allergy_" + allergyCount;

            const newAllergyInput = document.createElement("input");
            newAllergyInput.type = "text";
            newAllergyInput.id = "allergy_" + allergyCount;
            newAllergyInput.name = "allergy[]";

            newAllergyDiv.appendChild(newAllergyLabel);
            newAllergyDiv.appendChild(newAllergyInput);

            newAllergyFormRowDiv.appendChild(newAllergyDiv);

            allergyContainer.appendChild(newAllergyFormRowDiv);
        };

        function displayIngredient(selectId, imageContainerId) {
            const ingredientSelect = document.querySelector(`#${selectId}`);
            const imageContainer = document.querySelector(`#${imageContainerId}`);

            imageContainer.innerHTML = "";

            if (ingredientSelect.value !== "") {
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        let imgData = xhr.responseText;
                        imageContainer.innerHTML = `<img src="data:image/jpeg;base64,${imgData}" alt="Ingredient Image">`;
                    }
                };

                xhr.open("GET", "php/getIngredient.php?ingredient_name=" + ingredientSelect.value, true);
                xhr.send();
            } else {
                imageContainer.innerHTML = "";
            }
        };

        function addIngredient() {
            const allergyContainer = document.querySelector('#ingredient_container');

            // Create a new row for the ingredient
            const newRow = document.createElement('div');
            newRow.classList.add('form_row');

            const existingIngredientImgDiv = ingredient_container.querySelectorAll('[id^="ingredientImg_"]');
            const idCount = existingIngredientImgDiv.length + 1;

            const imageContainer = document.createElement('div');
            imageContainer.id = "ingredientImg_" + idCount;
            imageContainer.classList.add('ingrediantIconColumn');

            const ingrediantSelectColumn = document.createElement('div');
            ingrediantSelectColumn.classList.add('ingrediantSelectColumn');

            const newIngredientSelectLabel = document.createElement("label");
            newIngredientSelectLabel.htmlFor = "ingredientSelect_" + idCount;
            ingrediantSelectColumn.appendChild(newIngredientSelectLabel);

            const selectElement = document.createElement('select');
            selectElement.id = "ingredientSelect_" + idCount;
            selectElement.name = 'ingredient[]';
            selectElement.addEventListener('change', () => {
                displayIngredient("ingredientSelect_" + idCount, "ingredientImg_" + idCount);
            });

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select an Ingredient';
            selectElement.appendChild(defaultOption);

            <?php
            foreach ($ingredients as $ingredient) {
                echo "selectElement.options.add(new Option('{$ingredient['ingredient_name']}'));";
            }
            ?>

            ingrediantSelectColumn.appendChild(selectElement);

            const ingrediantQuantityColumn = document.createElement('div');
            ingrediantQuantityColumn.classList.add('ingrediantQuantityColumn');

            const newQuantityLabel = document.createElement('label');
            newQuantityLabel.htmlFor = "quantity_" + idCount;

            const newQuantityInput = document.createElement('input');
            newQuantityInput.type = 'number';
            newQuantityInput.id = "quantity_" + idCount;
            newQuantityInput.name = 'quantity[]';
            newQuantityInput.placeholder = 'Qt';

            ingrediantQuantityColumn.appendChild(newQuantityLabel);
            ingrediantQuantityColumn.appendChild(newQuantityInput);

            newRow.appendChild(imageContainer);
            newRow.appendChild(ingrediantSelectColumn);
            newRow.appendChild(ingrediantQuantityColumn);

            const ingredientContainer = document.querySelector('#ingredient_container');
            ingredientContainer.appendChild(newRow);
        };

        function addRecipeStep() {
            //Adds 1 to each new ID
            const recipeStepsContainer = document.querySelector('#recipeStep_container');

            const existingRecipeSteps = recipeStepsContainer.querySelectorAll('[id^="recipeStep_"]');
            const idCount = existingRecipeSteps.length + 1;

            //For Title
            const newRecipeStepFormRowDiv = document.createElement("div");
            newRecipeStepFormRowDiv.classList.add("form_row");
            newRecipeStepFormRowDiv.style.paddingBottom = "0px";

            const newRecipeStepInput = document.createElement("div");
            newRecipeStepInput.classList.add("one_column");

            const recipeStepLabel = document.createElement("label");
            recipeStepLabel.htmlFor = "recipeStep_" + idCount;

            const recipeStepInput = document.createElement("input");
            recipeStepInput.type = "text";
            recipeStepInput.name = "recipeSteps[]";
            recipeStepInput.id = "recipeStep_" + idCount;
            recipeStepInput.placeholder = "Title";

            newRecipeStepInput.appendChild(recipeStepLabel);
            newRecipeStepInput.appendChild(recipeStepInput);

            newRecipeStepFormRowDiv.appendChild(newRecipeStepInput);

            //For Description
            const newRecipeDescriptionFormRowDiv = document.createElement("div");
            newRecipeDescriptionFormRowDiv.classList.add("form_row");

            const newRecipeDescriptionInput = document.createElement("div");
            newRecipeDescriptionInput.classList.add("one_column");

            const recipeDescriptionLabel = document.createElement("label");
            recipeDescriptionLabel.htmlFor = "recipeDescription_" + idCount;

            const recipeDescriptionTextarea = document.createElement("textarea");
            recipeDescriptionTextarea.name = "recipeDescriptions[]";
            recipeDescriptionTextarea.id = "recipeDescription_" + idCount;
            recipeDescriptionTextarea.placeholder = "Description";

            newRecipeDescriptionInput.appendChild(recipeDescriptionLabel);
            newRecipeDescriptionInput.appendChild(recipeDescriptionTextarea);

            newRecipeDescriptionFormRowDiv.appendChild(newRecipeDescriptionInput);

            const recipeStepContainer = document.querySelector('#recipeStep_container');

            recipeStepContainer.appendChild(newRecipeStepFormRowDiv);
            recipeStepContainer.appendChild(newRecipeDescriptionFormRowDiv);
        };
    </script>
</head>

<body onload="setRating()">
    <div class="grid-container">
        <div id="inc-header"></div>
        <script>
            $(function() {
                $("#inc-header").load("structure/header.html")
            });
        </script>
        <div id="inc-top-nav"></div>
        <script>
            $(function() {
                $("#inc-top-nav").load("structure/top_nav.html")
            });
        </script>
        <div id="inc-side-nav"></div>
        <script>
            $(function() {
                $("#inc-side-nav").load("structure/side_nav.html")
            });
        </script>
        <div id="inc-left-ad">
            <div class="left-ad"></div>
        </div>

        <main onclick="hideSideNav()">

            <div id="head-content-ad">
                <div class="content-ad"></div>
            </div><!--Content Ad Head End-->

            <div class="main-content-div">

                <?php
                if ($confirmMessage) {
                ?>
                    <div class="confirmMessage">
                        <h2>Thank you. We have input your information.</h2>
                    </div>
                <?php
                } else {
                ?>
                    <!--Page Title Start-->
                    <div class="page-title">
                        <!--Title Here-->
                        <h1 style="text-align: center;">Add Recipe Form</h1>
                        Submit a reciept here. After it has been reviewed by the Admins, it will become live on the site for everyone to enjoy!
                        <br>* = required
                    </div>
                    <!--Page Title End-->

                    <form class="submit_recipe_form_styles" method="post" action="addRecipe.php" enctype="multipart/form-data" accept-charset="">
                        <div class="form_group">
                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="firstName">FIRST NAME/USERNAME*</label>
                                    <input type="text" id="firstName" name="firstName" placeholder="First Name/Username" required>
                                </div>
                                <div class="two_columns">
                                    <label for="lastName">LAST NAME</label>
                                    <input type="text" id="lastName" name="lastName" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="email">EMAIL*</label>
                                    <input type="email" id="email" name="email" placeholder="YourEmail@gmail.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeName">RECIPE NAME*</label>
                                    <input type="text" id="recipeName" name="recipeName" placeholder="Outrider's Champion Steak!" required>
                                </div>
                            </div>

                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeCategory">RECIPE CATEGORY*</label>
                                    <select type="text" id="recipeCategory" name="recipeCategory" required>
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
                                </div>
                            </div>


                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeImage">RECIPE IMAGE*</label>
                                    <input type="file" id="recipeImage" name="recipeImage" accept="image/*" required>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeDescription">RECIPE DESCRIPTION*</label>
                                    <textarea name="recipeDescription" id="recipeDescription" placeholder='"One side is obviously uncooked. The other side gives off a subtle scent of something burnt. Close your eyes and have a big mouthful, just to keep Amber happy if nothing else."' required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div class="form_row-difficulty">
                                <label for="difficultyRating" class="difficultyRating-label">DIFFICULTY*</label>
                                <div class="difficultyRating">
                                    <span class="star" onclick="setRating(1)">★</span>
                                    <span class="star" onclick="setRating(2)">★</span>
                                    <span class="star" onclick="setRating(3)">★</span>
                                    <span class="star" onclick="setRating(4)">★</span>
                                </div>
                                <input type="hidden" id="difficultyRating" name="difficultyRating" value="0" required>
                            </div>
                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="prepTime">TOTAL PREP TIME* (in minutes)</label>
                                    <input type="number" id="prepTime" name="prepTime" placeholder="20" required>
                                </div>
                                <div class="two_columns">
                                    <label for="cookTime">TOTAL COOK TIME* (in minutes)</label>
                                    <input type="number" id="cookTime" name="cookTime" placeholder="45" required>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="servingSize">SERVING SIZE* (in ounzes)</label>
                                    <input type="number" id="servingSize" name="servingSize" placeholder="6" required>
                                </div>
                                <div class="two_columns">
                                    <label for="calories">CALORIES* (per serving)</label>
                                    <input type="number" id="calories" name="calories" placeholder="425" required>
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div id="allergy_container">
                                <div class="form_row" style="padding-bottom: 0px;">
                                    <div class="one_column">
                                        <label for="allergy_1">ALLERGIES*</label>
                                        <input type="text" name="allergy[]" id="allergy_1" placeholder="Peanuts" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form_row" style="padding-top: 30px;">
                                <button type="button" id="add_allergy" onclick="addAllergy()">+ Add another Allergy</button>
                            </div>
                        </div>

                        <div class="form_group">
                            <div id="ingredient_container">
                                <label for="ingredientSelect_1">INGREDIENTS* (For 1 Serving)</label>
                                <div class="form_row">
                                    <div id="ingredientImg_1" class="ingrediantIconColumn"></div>
                                    <div class="ingrediantSelectColumn">
                                        <select name="ingredient[]" id="ingredientSelect_1" onchange="displayIngredient('ingredientSelect_1', 'ingredientImg_1')" required>
                                            <option value="">Select an Ingredient</option>
                                            <?php
                                            foreach ($ingredients as $ingredient) {
                                                echo "<option value='{$ingredient['ingredient_name']}'>{$ingredient['ingredient_name']}</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="ingrediantQuantityColumn">
                                        <label for="quantity_1"></label>
                                        <input type="number" name="quantity[]" id="quantity_1" placeholder="Qt" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form_row" style="padding-top: 30px;">
                                <button type="button" id="add_ingredient" onclick="addIngredient()">+ Add another
                                    Ingredient</button>
                            </div>
                        </div>

                        <div class="form_group">
                            <div id="recipeStep_container">
                                <div class="form_row" style="padding-bottom: 0px;">
                                    <div class="one_column">
                                        <label for="recipeStep_1">RECIPE STEPS*: TITLE & DESCRIPTION</label>
                                        <input type="text" name="recipeSteps[]" id="recipeStep_1" placeholder="Cut the Carrots" required>
                                    </div>
                                </div>
                                <div class="form_row">
                                    <div class="one_column">
                                        <label for="recipeDescription_1"></label>
                                        <textarea name="recipeDescriptions[]" id="recipeDescription_1" placeholder="Wash and cut the carrots into small, bite-sized pieces." required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form_row" style="padding-top: 30px;">
                                <button type="button" id="add_recipe_step" onclick="addRecipeStep()">+ Add another
                                    Step</button>
                            </div>
                        </div>


                        <p class="event_location">
                            <label for="event_location">HONEYPOT</label>
                            <input type="text" name="event_location" id="event_location">
                        </p>


                        <div class="form_row">
                            <div class="two_columns">
                                <input style="color: red;" type="reset" value="Reset">
                            </div>
                            <div class="two_columns">
                                <input style="color: green;" type="submit" name='submit' value="Submit">
                            </div>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
            <!--Content Div End-->
            <!--Content Ad Tail Start-->
            <div id="tail-content-ad">
                <div class="content-ad"></div>
            </div><!--Content Ad Tail End-->
        </main>
        <!--Content Area End-->
        <!--Right Ad Start-->
        <!--Right Ad Start-->
        <div id="inc-right-ad">
            <div class="right-ad"></div>
        </div> <!--Right Ad End-->
        <!--Right Ad End-->
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