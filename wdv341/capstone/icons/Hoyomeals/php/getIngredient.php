<?php
//ADD DESCRIPTION TOO - IMG AND DESCRIPTION

require '../dbConnect.php';

$ingredient_name = $_GET['ingredient_name'];

$sql = "SELECT ingredient_img FROM hoyomeals_ingredients WHERE ingredient_name = :ingredient_name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':ingredient_name', $ingredient_name, PDO::PARAM_STR);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo base64_encode($result['ingredient_img']); // Assuming the image is stored as BLOB
} else {
    echo ''; // Handle the case when ingredient not found
}
?>

