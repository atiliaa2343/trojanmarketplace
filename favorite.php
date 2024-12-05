<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "trojanmarketplace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simulate the logged-in student ID
session_start();
$_SESSION['student_id'] = '00247382';

// Check if student_id is set
if (!isset($_SESSION['student_id'])) {
    die("Please log in to view favorites.");
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT items.item_id, items.image, items.price, items.description, items.condition, items.date_time
        FROM favorites 
        JOIN items ON favorites.item_id = items.item_id 
        WHERE favorites.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$favorites = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $favorites[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - Trojan Marketplace</title>
    <link rel="stylesheet" href="favorites.css">
</head>
<body>
    <header>
        <h1>Favorites</h1>
    </header>
    <main>
        <div id="favorites">
            <h2>Your Favorites</h2>
            <div id="favorites-list" class="items-container">
                <!-- Items will be populated dynamically -->
            </div>
        </div>
    </main>
    <script>
        // Pass PHP data to JavaScript
        const favoritesData = <?php echo json_encode($favorites); ?>;

        document.addEventListener("DOMContentLoaded", function () {
            const favoritesList = document.getElementById('favorites-list');

            if (favoritesData.length === 0) {
                favoritesList.innerHTML = '<p>No items in your favorites.</p>';
                return;
            }

            favoritesData.forEach(item => {
                const itemCard = document.createElement('div');
                itemCard.className = 'item-card';
                itemCard.innerHTML = `
                    <img src="${item.image}" alt="${item.description}" class="item-image" />
                    <h3>${item.description}</h3>
                    <p>Price: $${item.price}</p>
                    <p>Condition: ${item.condition}</p>
                    <p>Date Added: ${new Date(item.date_time).toLocaleDateString()}</p>
                `;
                favoritesList.appendChild(itemCard);
            });
        });
    </script>
</body>
</html>

