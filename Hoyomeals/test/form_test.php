<?php
require 'dbConnect.php';

$sql = "SELECT ingredient_name, ingredient_img FROM hoyomeals_ingredients";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/hoyomeals/css/styles.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="/hoyomeals/script/script.js"></script>

    <script>
        // rename and understand
        // incorporate other stuff
        // add another button and function
        //pass parameters 

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
    </script>
</head>

<body>
    <form action="">
        <div class="form_group">
            <label for="ingredient">INGREDIENTS</label>
            <div id="ingredient_container">
                <div class="form_row">
                    <div id="imageContainer1" class="ingrediantIconColumn"></div>
                    <div class="ingrediantSelectColumn">
                        <select id="ingredient1" name="ingredient" onchange="displayIngredient('ingredient1', 'imageContainer1')">
                        <option value="">Select an Ingredient</option>
                            <?php
                            foreach ($ingredients as $ingredient) {
                                echo "<option value='{$ingredient['ingredient_name']}'>{$ingredient['ingredient_name']}</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="ingrediantQuantityColumn">
                        <label for="quantity1"></label>
                        <input type="number" id="quantity1" name="quantity" placeholder="Qt">
                    </div>
                </div>




            </div>
    </form>



</body>

</html>