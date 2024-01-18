<?php
require 'dbConnect.php';

$sql = "SELECT ingredient_name, ingredient_img FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {

    $HONEYPOT = $_POST['event_location']; //HONEYPOT 
    if (empty($HONEYPOT)) {

        $inAuthorName = $_POST['firstName'];

        //mySQL command
        $sql = "INSERT INTO hoyomeals_recipes_temp";
        $sql .= "(recipe_nameTemp, recipe_dateEnteredTemp)";
        $sql .= " VALUES ";
        $sql .= "(:authorFirstName, :recipeDateEntered)";

        //prepared statement
        $stmt = $conn->prepare($sql);

        //current date object
        $today = date("Y-m-d");

        //bind what was inputed with columns in table
        $stmt->bindParam(':authorFirstName', $inAuthorName);
        $stmt->bindParam(':recipeDateEntered', $today);

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
    <script nonce="JEKEY9rNjqvUAy5TyTJ0qw">
        (function() {
            function signalGooglefcPresent() {
                if (!window.frames['googlefcPresent']) {
                    if (document.body) {
                        const iframe = document.createElement('iframe');
                        iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;';
                        iframe.style.display = 'none';
                        iframe.name = 'googlefcPresent';
                        document.body.appendChild(iframe);
                    } else {
                        setTimeout(signalGooglefcPresent, 0);
                    }
                }
            }
            signalGooglefcPresent();
        })();
    </script>

    <title>!TITLE!</title>
    <meta name="keywords" content="!KEYWORDS!">
    <meta name="description" content="!DESCRIPTION!">
    <style>
        .recipeNumber {
            display: none;
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

            const newAllergyInput = document.createElement("input");
            newAllergyInput.type = "text";
            newAllergyInput.id = "allergy_" + allergyCount;
            newAllergyInput.name = "allergy";

            newAllergyDiv.appendChild(newAllergyInput);
            newAllergyFormRowDiv.appendChild(newAllergyDiv);

            allergyContainer.appendChild(newAllergyFormRowDiv);
        }

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
            const formGroup = document.querySelector('.form_group');

            const rowCount = document.querySelectorAll('.form_row').length;

            const newRow = document.createElement('div');
            newRow.classList.add('form_row');

            const imageContainerId = `imageContainer${rowCount + 1}`;
            const ingredientId = `ingredient${rowCount + 1}`;
            const quantityId = `quantity${rowCount + 1}`;

            const imageContainer = document.createElement('div');
            imageContainer.id = imageContainerId;
            imageContainer.classList.add('ingrediantIconColumn');

            const ingrediantSelectColumn = document.createElement('div');
            ingrediantSelectColumn.classList.add('ingrediantSelectColumn');

            const selectElement = document.createElement('select');
            selectElement.id = ingredientId;
            selectElement.name = 'ingredient';
            selectElement.addEventListener('change', () => {
                displayIngredient(ingredientId, imageContainerId);
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

            const labelElement = document.createElement('label');
            labelElement.htmlFor = quantityId;

            const inputElement = document.createElement('input');
            inputElement.type = 'number';
            inputElement.id = quantityId;
            inputElement.name = 'quantity';
            inputElement.placeholder = 'Qt';

            ingrediantQuantityColumn.appendChild(labelElement);
            ingrediantQuantityColumn.appendChild(inputElement);

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
            const stepCount = existingRecipeSteps.length + 1;

            //For Title
            const newRecipeStepFormRowDiv = document.createElement("div");
            newRecipeStepFormRowDiv.classList.add("form_row");
            newRecipeStepFormRowDiv.style.paddingBottom = "0px";

            const newRecipeStepInput = document.createElement("div");
            newRecipeStepInput.classList.add("one_column");

            const recipeStepLabel = document.createElement("label");
            recipeStepLabel.setAttribute("for", "recipeStep");

            const recipeStepInput = document.createElement("input");
            recipeStepInput.type = "text";
            recipeStepInput.name = "recipeStep";
            recipeStepInput.id = "recipeStep_" + stepCount;
            recipeStepInput.placeholder = "Title";

            newRecipeStepInput.appendChild(recipeStepLabel);
            newRecipeStepInput.appendChild(recipeStepInput);

            newRecipeStepFormRowDiv.appendChild(newRecipeStepInput);

            //Adds 1 to each new ID
            const recipeDescriptionContainer = document.querySelector('#recipeStep_container');

            const existingRecipeDescriptions = recipeDescriptionContainer.querySelectorAll('[id^="recipeDescription_"]');
            const descriptionCount = existingRecipeDescriptions.length + 1;

            //For Description
            const newRecipeDescriptionFormRowDiv = document.createElement("div");
            newRecipeDescriptionFormRowDiv.classList.add("form_row");

            const newRecipeDescriptionInput = document.createElement("div");
            newRecipeDescriptionInput.classList.add("one_column");

            const recipeDescriptionLabel = document.createElement("label");
            recipeDescriptionLabel.setAttribute("for", "recipeDescription");

            const recipeDescriptionTextarea = document.createElement("textarea");
            recipeDescriptionTextarea.name = "recipeDescription";
            recipeDescriptionTextarea.id = "recipeDescription_" + descriptionCount;
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
                    <h1 style="text-align: center;">Add Recipe Form</h1>
                    Submit a reciept here. After it has been reviewed by the Admins, it will become live on the site for everyone to enjoy!
                    <br>* = required
                </div>
                <!--Page Title End-->

                <form class="form_styles" action="">
                    <div class="form_group">
                        <div class="form_row">
                            <div class="two_columns">
                                <label for="firstName">FIRST NAME/USERNAME*</label>
                                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
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
                        <div class="form_row, recipeNumber">
                            <div class="one_column">
                                <label for="recipeNumber">RECIPE NUMBER*</label>
                                <input type="text" id="recipeNumber" name="recipeNumber" placeholder="Number of recipe submitted">
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
                                <label for="firstName">TOTAL PREP TIME* (in minutes)</label>
                                <input type="number" id="firstName" name="firstName" placeholder="20" required>
                            </div>
                            <div class="two_columns">
                                <label for="lastName">TOTAL COOK TIME* (in minutes)</label>
                                <input type="number" id="lastName" name="lastName" placeholder="45" required>
                            </div>
                        </div>
                        <div class="form_row">
                            <div class="two_columns">
                                <label for="firstName">SERVING SIZE* (in ounzes)</label>
                                <input type="number" id="firstName" name="firstName" placeholder="6" required>
                            </div>
                            <div class="two_columns">
                                <label for="lastName">CALORIES* (per serving)</label>
                                <input type="number" id="lastName" name="lastName" placeholder="425" required>
                            </div>
                        </div>
                    </div>

                    <div class="form_group">
                        <div id="allergy_container">
                            <div class="form_row" style="padding-bottom: 0px;">
                                <div class="one_column">
                                    <label for="allergy">ALLERGIES*</label>
                                    <input type="text" id="allergy_1" name="allergy" placeholder="Peanuts" required>
                                </div>
                            </div>
                        </div>
                        <div class="form_row" style="padding-top: 30px;">
                            <button type="button" id="add_allergy" onclick="addAllergy()">+ Add another Allergy</button>
                        </div>
                    </div>

                    <div class="form_group">
                        <label for="ingredient">INGREDIENTS* (For 1 Serving)</label>
                        <div id="ingredient_container">
                            <div class="form_row">
                                <div id="imageContainer1" class="ingrediantIconColumn"></div>
                                <div class="ingrediantSelectColumn">
                                    <select id="ingredient1" name="ingredient" onchange="displayIngredient('ingredient1', 'imageContainer1')" required>
                                        <option value="">Select an Ingredient</option>
                                        <?php
                                        foreach ($ingredients as $ingredient) {
                                            echo "<option value='{$ingredient['ingredient_name']}'>{$ingredient['ingredient_name']}</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="ingrediantQuantityColumn">
                                    <label for="quantity1"></label>
                                    <input type="number" id="quantity1" name="quantity" placeholder="Qt" required>
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
                                    <label for="recipeStep">RECIPE STEPS*: TITLE & DESCRIPTION</label>
                                    <input type="text" id="recipeStep_1" name="  recipeStep" placeholder="Cut the Carrots" required>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="one_column">
                                    <label for="recipeDescription"></label>
                                    <textarea name="recipeDescription" id="recipeDescription_1" placeholder="Wash and cut the carrots into small, bite-sized pieces." required></textarea>
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
                            <input style="color: green;" type="submit" value="Submit">
                        </div>
                    </div>
                </form>
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