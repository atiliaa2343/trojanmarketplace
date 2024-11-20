<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $insertImage = $_FILES["insertImage"]["name"];
    $TitleItem = $_POST["TitleItem"];
    $conditionItem = $_POST["conditionItem"];
    $priceItem = $_POST["priceItem"];

echo "Image: " .htmlspecialchars($insertImage) . "<br>";
echo "Title for post: " .htmlspecialchars($TitleItem) . "<br>";
echo "Condition: " .htmlspecialchars($conditionItem) . "<br>";
echo "Price for Item: " .htmlspecialchars($priceItem) . "<br>";

}
?>