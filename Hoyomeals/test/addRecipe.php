<?php
session_start();

if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== 'valid') {
    header('Location: login.php');
    exit();
};

require '../dbConnect.php';

$sql = "SELECT ingredient_name FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$confirmMessage = false;
$invalidFirstName = false;
$invalidLastName = false;
$invalidEmail = false;
$invalidRecipeName = false;
$invalidRecipeImage = false;
$invalidRecipeDescription = false;
$invalidPrepTime = false;
$invalidCookTime = false;
$invalidServingSize = false;
$invalidCalories = false;
$invalidAllergy = false;
$invalidQuantity = false;
$invalidIngredientName = false;
$invalidStepTitle = false;
$invalidStepDescription = false;
$invalidRecipeSteps = false;

//Global Variables to maintain state in form
$inAuthorFirstName = "";
$inAuthorLastName = "";
$inAuthorEmail = "";
$inRecipeName = "";
$inDescription = "";
$inPrepTime = "";
$inCookTime = "";
$inServingSize = "";
$inCalories = "";

if (isset($_POST['submit'])) {

    $recipeNumber = $_POST['recipeNumber']; // Honeypot
    if (empty($recipeNumber)) {

        $proceedWithFormProcessing = true;

        //Variables used for Maintaining form state but not validation
        $inCategory = $_POST['recipeCategory'];
        $inDifficulty = $_POST['difficultyRating'];
        //Allergy, Ingredient, Step Title, Step description unsure how to maintain their state



        //Same , but also used for validation
        $inAuthorFirstName = $_POST['firstName'];
        $inAuthorLastName = $_POST['lastName'];
        $inAuthorEmail = $_POST['email'];
        $inRecipeName = $_POST['recipeName'];
        $inDescription = $_POST['recipeDescription'];
        $inPrepTime = $_POST['prepTime'];
        $inCookTime = $_POST['cookTime'];
        $inServingSize = $_POST['servingSize'];
        $inCalories = $_POST['calories'];

        //Form Validation
        //First Name Validation
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $inAuthorFirstName)) {
            $invalidFirstName = true;
            $proceedWithFormProcessing = false;
        };

        //Last Name Validation
        if (!preg_match('/^[A-Za-z]+$/', $inAuthorLastName)) {
            $invalidLastName = true;
            $proceedWithFormProcessing = false;
        };

        //Email Validation
        if (!preg_match('/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/', $inAuthorEmail)) {
            $invalidEmail = true;
            $proceedWithFormProcessing = false;
        };

        //Recipe Name Validation
        if (strpbrk($inRecipeName, '{}') !== false) {
            $invalidRecipeName = true;
            $proceedWithFormProcessing = false;
        };

        //Image Validation
        if (
            isset($_FILES["recipeImage"]) && $_FILES["recipeImage"]["error"] == 0 &&
            exif_imagetype($_FILES["recipeImage"]["tmp_name"]) !== IMAGETYPE_WEBP
        ) {
            $invalidRecipeImage = true;
            $proceedWithFormProcessing = false;
        };

        //Recipe Description Validation
        if (strpbrk($inDescription, '{}') !== false) {
            $invalidRecipeDescription = true;
            $proceedWithFormProcessing = false;
        };

        //Prep Time Validation
        if (!is_numeric($inPrepTime) || $inPrepTime < 0 || $inPrepTime > 1440) {
            $invalidPrepTime = true;
            $proceedWithFormProcessing = false;
        };

        //Cook Time Validation
        if (!is_numeric($inCookTime) || $inCookTime < 0 || $inCookTime > 1440) {
            $invalidCookTime = true;
            $proceedWithFormProcessing = false;
        };


        //Serving Size Validation
        if (!is_numeric($inServingSize) || $inServingSize < 1 || $inServingSize > 100) {
            $invalidServingSize = true;
            $proceedWithFormProcessing = false;
        };


        //Calorie Validation
        if (!is_numeric($inCalories) || $inCalories < 5 || $inCalories > 3000) {
            $invalidCalories = true;
            $proceedWithFormProcessing = false;
        };


        //Allergy Validation
        foreach ($_POST['allergy'] as $allergy) {
            if (!preg_match('/^[A-Za-z]+$/', $allergy)) {
                $invalidAllergy = true;
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Ingredient Quantity Validation
        foreach ($_POST['quantity'] as $quantity) {
            if (!is_numeric($quantity) || $quantity < 1 || $quantity > 10) {
                $invalidQuantity = true;
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Ingredient Quantity and Ingredient Name Validation
        for ($i = 0; $i < count($_POST['ingredient']); $i++) {
            $ingredientName = $_POST['ingredient'][$i];
            $quantity = (int)$_POST['quantity'][$i]; // Cast to integer

            if ($quantity > 1 && empty($ingredientName)) {
                $invalidIngredientName = true;
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Step Title Validation
        foreach ($_POST['recipeSteps'] as $stepTitle) {
            if (strpbrk($stepTitle, '{}')) {
                $invalidStepTitle = true;
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Step Description Validation
        foreach ($_POST['recipeDescriptions'] as $stepDescription) {
            if (strpbrk($stepDescription, '{}')) {
                $invalidStepDescription = true;
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Step Title and Description Validation
        for ($i = 0; $i < count($_POST['recipeSteps']); $i++) {
            $stepTitles = $_POST['recipeSteps'][$i];
            $stepDescriptions = $_POST['recipeDescriptions'][$i];

            if (!empty($stepDescriptions) && empty($stepTitles)) {
                $invalidRecipeSteps = true; // You can customize the error flag name
                $proceedWithFormProcessing = false;
                break;
            }
        };

        //Form Processing
        if ($proceedWithFormProcessing) {
            $inCategory = $_POST['recipeCategory'];
            $inDifficulty = $_POST['difficultyRating'];
            $inAuthorFirstName = $_POST['firstName'];
            $inAuthorLastName = $_POST['lastName'];
            $inAuthorEmail = $_POST['email'];
            $inRecipeName = $_POST['recipeName'];
            $inDescription = $_POST['recipeDescription'];
            $inPrepTime = $_POST['prepTime'];
            $inCookTime = $_POST['cookTime'];
            $inServingSize = $_POST['servingSize'];
            $inCalories = $_POST['calories'];
            $inAuthorName = $inAuthorFirstName . ' ' . $inAuthorLastName;

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
            };

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
        }
    } else {
        //If Honeypot is triggered
        die("Suspicious activity has been detected. Further suspicious attempts will result in an IP ban.");
    }
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
    <style>
        .recipeNumber {
            display: none;
        }
    </style>

    <title>Hoyomeals: Add a Recipe</title>
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

                xhr.open("GET", "php/getIngredientImg.php?ingredient_name=" + ingredientSelect.value, true);
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

        function maintainCategoryState(categoryState) {
            let categoryDropdown = document.querySelector('#recipeCategory');

            if (categoryState) {
                categoryDropdown.value = categoryState;
            } else {
                categoryDropdown.value = '';
            }
        };

        function maintainDifficultyRating(inDifficulty) {
            if (inDifficulty == "1") {
                document.querySelector('#difficultyStar1').classList.add('selected');
                document.querySelector('#difficultyRating').value = "1";
            };
            if (inDifficulty == "2") {
                document.querySelector('#difficultyStar1').classList.add('selected');
                document.querySelector('#difficultyStar2').classList.add('selected');
                document.querySelector('#difficultyRating').value = "2";
            };
            if (inDifficulty == "3") {
                document.querySelector('#difficultyStar1').classList.add('selected');
                document.querySelector('#difficultyStar2').classList.add('selected');
                document.querySelector('#difficultyStar3').classList.add('selected');
                document.querySelector('#difficultyRating').value = "3";
            };
            if (inDifficulty == "4") {
                document.querySelector('#difficultyStar1').classList.add('selected');
                document.querySelector('#difficultyStar2').classList.add('selected');
                document.querySelector('#difficultyStar3').classList.add('selected');
                document.querySelector('#difficultyStar4').classList.add('selected');
                document.querySelector('#difficultyRating').value = "4";
            };
        };

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
    </script>
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
                <?php
                if ($confirmMessage) {
                ?>
                    <div class="confirmMessage">
                        <h2>Thank you. We have recieved your Recipe. After the Admins have approved it, it'll become public on Hoyomeals for everyone to enjoy!.</h2>
                    </div>
                <?php
                } else {
                ?>
                    <div class="page-title">
                        <h1 style="text-align: center;">Add Recipe Form</h1>
                        Submit your Recipe here. It will become public on Hoyomeals for everyone to enjoy after being approved by the Admins!
                        <br>Double check what you enter carefully. You're recipe will be rejected if there are any errors. The Admins will not correct any mistakes.
                        <br>* = required
                    </div>

                    <form class="submit_recipe_form_styles" method="post" action="addRecipe.php" enctype="multipart/form-data" accept-charset="">
                        <div class="form_group">
                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="firstName">FIRST NAME/USERNAME*</label>
                                    <input type="text" id="firstName" name="firstName" placeholder="First Name/Username" value="<?php echo $inAuthorFirstName ?>">
                                    <?php if ($invalidFirstName) {
                                        echo "<div style='color: red;'>Please enter a valid First Name/Username. Spaces and special characters other than _ are not allowed.</div>";
                                    } ?>
                                </div>

                                <div class="two_columns">
                                    <label for="lastName">LAST NAME</label>
                                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $inAuthorLastName ?>">
                                    <?php if ($inAuthorLastName) {
                                        echo "<span style='color: red;'>Please enter a valid Last Name. Only letters are allowed.</span>";
                                    } ?>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="email">EMAIL*</label>
                                    <input type="email" id="email" name="email" placeholder="YourEmail@gmail.com" value="<?php echo $inAuthorEmail ?>">
                                    <?php if ($invalidEmail) {
                                        echo "<span style='color: red;'>Please enter a valid Email. Spaces and specials characters other than @ and . are not allowed.</span>";
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeName">RECIPE NAME*</label>
                                    <input type="text" id="recipeName" name="recipeName" placeholder="Outrider's Champion Steak!" value="<?php echo $inRecipeName ?>">
                                    <?php if ($invalidRecipeName) {
                                        echo "<span style='color: red;'>Please enter a valid Recipe Name. { and } are not allowed.</span>";
                                    } ?>
                                </div>
                            </div>

                            <div class="form_row">
                                <div class="one_column">
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
                                    <script>
                                        maintainCategoryState('<?php echo $inCategory ?>')
                                    </script>
                                </div>
                            </div>


                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeImage">RECIPE IMAGE*</label>
                                    <input type="file" id="recipeImage" name="recipeImage" accept="image/*">
                                    <?php if ($invalidRecipeImage) {
                                        echo "<span style='color: red;'>Please upload a valid Ingredient Image. Only .WebP types are allowed.</span>";
                                    } ?>
                                </div>
                            </div>

                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeDescription">RECIPE DESCRIPTION*</label>
                                    <textarea name="recipeDescription" id="recipeDescription" placeholder='"One side is obviously uncooked. The other side gives off a subtle scent of something burnt. Close your eyes and have a big mouthful, just to keep Amber happy if nothing else."'><?php echo $inDescription ?></textarea>
                                    <?php if ($invalidRecipeDescription) {
                                        echo "<span style='color: red;'>Please enter a valid Recipe Description. { and } are not allowed.</span>";
                                    } ?>
                                </div>
                            </div>

                            <div class="recipeNumber">
                                <div class="one_column">
                                    <label for="recipeNumber">RECIPE NUMBER</label>
                                    <input type="number" id="recipeNumber" name="recipeNumber" placeholder="Number of recipes submitted">
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div class="form_row-difficulty">
                                <label for="difficultyRating" class="difficultyRating-label">DIFFICULTY*</label>
                                <div class="difficultyRating">
                                    <span id="difficultyStar1" class="star" onclick="setRating(1)">★</span>
                                    <span id="difficultyStar2" class="star" onclick="setRating(2)">★</span>
                                    <span id="difficultyStar3" class="star" onclick="setRating(3)">★</span>
                                    <span id="difficultyStar4" class="star" onclick="setRating(4)">★</span>
                                </div>
                                <input type="hidden" id="difficultyRating" name="difficultyRating">
                                <script>
                                    maintainDifficultyRating('<?php echo $inDifficulty; ?>')
                                </script>
                            </div>

                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="prepTime">TOTAL PREP TIME* (in minutes)</label>
                                    <input type="number" id="prepTime" name="prepTime" placeholder="20" value="<?php echo $inPrepTime ?>">
                                    <?php if ($invalidPrepTime) {
                                        echo "<span style='color: red;'>Please enter a valid Prep Time. Only 0 to 1440 minutes are allowed.</span>";
                                    } ?>
                                </div>

                                <div class="two_columns">
                                    <label for="cookTime">TOTAL COOK TIME* (in minutes)</label>
                                    <input type="number" id="cookTime" name="cookTime" placeholder="45" value="<?php echo $inCookTime ?>">
                                    <?php if ($invalidCookTime) {
                                        echo "<span style='color: red;'>Please enter a valid Cook Time. Only 0 to 1440 minutes are allowed.</span>";
                                    } ?>
                                </div>
                            </div>

                            <div class="form_row">
                                <div class="two_columns">
                                    <label for="servingSize">SERVING SIZE* (in ounces)</label>
                                    <input type="number" id="servingSize" name="servingSize" placeholder="6" value="<?php echo $inServingSize ?>">
                                    <?php if ($invalidServingSize) {
                                        echo "<span style='color: red;'>Please enter a valid Serving Size. Only 1 to 100 ounces are allowed.</span>";
                                    } ?>
                                </div>

                                <div class="two_columns">
                                    <label for="calories">CALORIES* (per serving)</label>
                                    <input type="number" id="calories" name="calories" placeholder="425" value="<?php echo $inCalories ?>">
                                    <?php if ($invalidCalories) {
                                        echo "<span style='color: red;'>Please enter a valid Calorie. Only 5 to 3000 are allowed.</span>";
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <div class="form_group">
                            <div id="allergy_container">
                                <div class="form_row" style="padding-bottom: 0px;">
                                    <div class="one_column">
                                        <?php if ($invalidAllergy) {
                                            echo "<span style='color: red;'>Please enter valid Allergies. Only letters and no spaces are allowed.</span>";
                                        } ?>
                                        <label for="allergy_1">ALLERGIES</label>
                                        <input type="text" name="allergy[]" id="allergy_1" placeholder="Peanuts">
                                    </div>
                                </div>
                            </div>
                            <div class="form_row" style="padding-top: 30px;">
                                <button type="button" id="add_allergy" onclick="addAllergy()">+ Add another Allergy</button>
                            </div>
                        </div>

                        <div class="form_group">
                            <div id="ingredient_container">
                                <?php if ($invalidQuantity) {
                                    echo "<span style='color: red;'>Please enter a valid Ingredient Quantity. Only 1 to 10 are allowed.</span>";
                                } ?>

                                <?php if ($invalidIngredientName) {
                                    echo "<span style='color: red;'>Please select a valid Ingredient. If the Quantity is greater than 0, an Ingredient must be selected.</span>";
                                } ?>
                                <label for="ingredientSelect_1">INGREDIENTS* (For 1 Serving)</label>
                                <div class="form_row">
                                    <div id="ingredientImg_1" class="ingrediantIconColumn"></div>
                                    <div class="ingrediantSelectColumn">
                                        <select name="ingredient[]" id="ingredientSelect_1" onchange="displayIngredient('ingredientSelect_1', 'ingredientImg_1')">
                                            <option value="">Select an Ingredient</option>
                                            <?php
                                            foreach ($ingredients as $ingredient) {
                                                echo "<option value='{$ingredient['ingredient_name']}'>{$ingredient['ingredient_name']}</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="ingrediantQuantityColumn">
                                        <label for="quantity_1"></label>
                                        <input type="number" name="quantity[]" id="quantity_1" placeholder="Qt">
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
                                        <?php if ($invalidStepTitle) {
                                            echo "<span style='color: red;'>Please enter valid Step Titles. { and } are not allowed.</span>";
                                        } ?>

                                        <?php if ($invalidStepDescription) {
                                            echo "<span style='color: red;'>Please enter valid Step Descriptions. { and } are not allowed.</span>";
                                        } ?>

                                        <?php if ($invalidRecipeSteps) {
                                            echo "<span style='color: red;'>Please enter valid Step Title. If Step Description has a value, Step Title must also have a value.</span>";
                                        } ?>
                                        <label for="recipeStep_1">RECIPE STEPS*: TITLE & DESCRIPTION</label>
                                        <input type="text" name="recipeSteps[]" id="recipeStep_1" placeholder="Cut the Carrots">
                                    </div>
                                </div>
                                <div class="form_row">
                                    <div class="one_column">
                                        <label for="recipeDescription_1"></label>
                                        <textarea name="recipeDescriptions[]" id="recipeDescription_1" placeholder="Wash and cut the carrots into small, bite-sized pieces."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form_row" style="padding-top: 30px;">
                                <button type="button" id="add_recipe_step" onclick="addRecipeStep()">+ Add another
                                    Step</button>
                            </div>
                        </div>

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

            <!-- Start of site skeleton structure -->
            <div id="tail-content-ad">
                <div class="content-ad"><img src="/hoyomeals/img/icon/ad2.jpg" alt="tail_ad"></div>
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