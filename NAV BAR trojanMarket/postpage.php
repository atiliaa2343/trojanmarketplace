<?php
header("Location: http://localhost/NAV%20BAR%20trojanMarket/postPage.html ");
exit();

echo "Post Details <br>";
echo "---------------------- <br>";

$student_id = "247382";
echo "student: ".$student_id."<br>";

$timeAndDay = date("Y-m-d H:i:s");
echo "date posted: ".$timeAndDay."<br>";

$TitleItem = $_POST["TitleItem"];
echo "Title for Post: ".$TitleItem."<br>";

$conditionItem = $_POST["conditionItem"];
echo "Condition: ".$conditionItem."<br>";

$insertImage = $_FILES["insertImage"]["name"];
echo "Image: ".$insertImage."<br>";

$priceItem = $_POST["priceItem"];
echo "Price of Item: ".$priceItem."<br>";

$category_id = 0;
$category = $_POST["category"];
if ($category == "Home Goods") {
    $category_id = 1; // Corrected assignment operator
} else if ($category == "Vehicles") {
    $category_id = 2;
} else if ($category == "Miscellaneous") {
    $category_id = 3;
} else if ($category == "Services") {
    $category_id = 4;
} else if ($category == "Music") {
    $category_id = 5;
} else if ($category == "Supplies") {
    $category_id = 6;
} else if ($category == "Lifestyle") {
    $category_id = 7;
} else if ($category == "Clothes") {
    $category_id = 8;
} else if ($category == "Shoes") {
    $category_id = -1;
} else {
    // Default or error handling if needed
}

echo "Category of Item: ".$category_id."<br>";

$description = $_POST["description"];
echo "description: ".$description."<br>";

$servername = "localhost";
$username = "MiAngel";
$password = "test321";
$dbname = "trojanmarket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection established!";

// Escape the inputs to avoid SQL injection
$student_id = $conn->real_escape_string($student_id);
$insertImage = $conn->real_escape_string($insertImage);
$conditionItem = $conn->real_escape_string($conditionItem);
$description = $conn->real_escape_string($description);
$timeAndDay = $conn->real_escape_string($timeAndDay);
$priceItem = $conn->real_escape_string($priceItem);
$category_id = (int)$category_id;  // Make sure category_id is an integer

// Corrected SQL query with backticks for reserved word `condition`
$sql = "INSERT INTO items_ (item_id, category_id, student_id, image, description, `condition`, date_time, price)
        VALUES (rand(), $category_id, '$student_id', '$insertImage', '$description', '$conditionItem', '$timeAndDay', $priceItem)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>
