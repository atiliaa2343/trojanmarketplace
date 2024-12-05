<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "trojanmarketplace";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission for creating a post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['TitleItem'])) {
    $student_id = "247382"; // Example student ID; replace with actual logic if needed
    $timeAndDay = date("Y-m-d H:i:s");
    $TitleItem = $_POST["TitleItem"];
    $conditionItem = $_POST["conditionItem"];
    $insertImage = $_FILES["insertImage"]["name"];
    $priceItem = $_POST["priceItem"];
    $description = $_POST["description"];

    // Determine category ID based on the selected category
    $categories = [
        "Home Goods" => 1,
        "Vehicles" => 2,
        "Miscellaneous" => 3,
        "Services" => 4,
        "Music" => 5,
        "Supplies" => 6,
        "Lifestyle" => 7,
        "Clothes" => 8,
        "Shoes" => -1
    ];
    $category = $_POST["category"];
    $category_id = $categories[$category] ?? 0;

    // Escape the inputs to avoid SQL injection
    $student_id = $conn->real_escape_string($student_id);
    $insertImage = $conn->real_escape_string($insertImage);
    $conditionItem = $conn->real_escape_string($conditionItem);
    $description = $conn->real_escape_string($description);
    $timeAndDay = $conn->real_escape_string($timeAndDay);
    $priceItem = $conn->real_escape_string($priceItem);

    // Insert the post into the database
    $sql = "INSERT INTO items_ (item_id, category_id, student_id, image, description, `condition`, date_time, price)
            VALUES (rand(), $category_id, '$student_id', '$insertImage', '$description', '$conditionItem', '$timeAndDay', $priceItem)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Post created successfully!');</script>";
    } else {
        echo "<script>alert('Error creating post: " . $conn->error . "');</script>";
    }
}

// Check if the request is to fetch data (AJAX request)
if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
    header('Content-Type: application/json');
    $items = [];

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];
        $sql = "SELECT item_id, image, price, description, `condition`
                FROM Items
                JOIN Categories ON Items.category_id = Categories.category_id
                WHERE Categories.category_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category);
    } else {
        $sql = "SELECT item_id, image, price, description, `condition` FROM Items";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    echo json_encode($items);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trojan Marketplace</title>
    <link rel="stylesheet" href="home.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="vsu.png" alt="Logo">
        </div>
        <div class="navbar-title">
            Trojan Marketplace
        </div>
        <input type="text" placeholder="Search on Trojan Marketplace" class="search-bar">
        <div class="navbar-buttons">
            <button class = "navbar-button" onclick="displayCreatePost()">Create A Post</button>
        </div>
        <div class="navbar-buttons">
            <button class="navbar-button" onclick="navigateToWelcomePage()" >Sign Up</button>
        </div>
    </header>

    <main>
        <!-- Home Page Content -->
        <div id="homePageDiv" style="display: block;">
            <div class="nav-icons">
                <a href="#" class="icon-btn" title="Home">
                    <i class="fa-solid fa-house"></i>
                </a>
                <a href="messages.html" class="icon-btn" title="Messages">
                    <i class="fa-solid fa-envelope"></i>
                </a>
                <a href="bids.php" class="icon-btn" title="Bids">
                    <i class="fa-solid fa-gavel"></i>
                </a>
                <a href="#" class="icon-btn" title="Favorites">
                    <i class="fa-solid fa-heart"></i>
                </a>
            </div>
            <aside class="sidebar">
                <h3>Today's Picks</h3>
                <div class="price-filter">
                    <label>Price $</label>
                    <input type="number" placeholder="Min">
                    <input type="number" placeholder="Max">
                </div>
                <h4>Product Categories</h4>
                <ul class="categories">
                    <li id="clothes-category" data-category="Clothes" role="button">Clothes</li>
                    <li data-category="Shoes" role="button">Shoes</li>
                    <li data-category="Lifestyle" role="button">Lifestyle</li>
                    <li data-category="Home Goods" role="button">Home Goods</li>
                    <li data-category="Vehicles" role="button">Vehicles</li>
                    <li data-category="Miscellaneous" role="button">Miscellaneous</li>
                </ul>
            </aside>
            <section id="items-display" class="posts-grid"></section>
        </div>

        <!-- Create Post Section -->
        <div id="createPostDiv" style="display:none;">
            
            <body>
                <!-- Home Page Content -->
            <div id="homePageDiv" style="display: block;">
            <div class="nav-icons">
                <a href="#" class="icon-btn" title="Home">
                    <i class="fa-solid fa-house"></i>
                </a>
                <a href="messages.html" class="icon-btn" title="Messages">
                    <i class="fa-solid fa-envelope"></i>
                </a>
                <a href="bids.php" class="icon-btn" title="Bids">
                    <i class="fa-solid fa-gavel"></i>
                </a>
                <a href="#" class="icon-btn" title="Favorites">
                    <i class="fa-solid fa-heart"></i>
                </a>
            </div>
            <h1>Create A Post</h1>
            <form id="createPostForm" action="" method="post" enctype="multipart/form-data">
                <label>Choose Category for post</label><br>
                <select id="category" name="category">
                    <option>---</option>
                    <option value="Home Goods">Home Goods</option>
                    <option value="Vehicles">Vehicles</option>
                    <option value="Miscellaneous">Miscellaneous</option>
                    <option value="Services">Services</option>
                    <option value="Music">Music</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Clothes">Clothes</option>
                    <option value="Shoes">Shoes</option>
                </select><br><br>
                <label>Insert Image</label>
                <input type="file" name="insertImage">
                <label>Title for post: </label>
                <input type="text" name="TitleItem">
                <label>Condition: </label>
                <input type="text" name="conditionItem">
                <label>Price for item: </label>
                <input type="number" name="priceItem">
                <label>Description: </label>
                <textarea name="description" rows="8"></textarea>
                <input type="submit" value="Post" style="background-color: orange;">
            </form>
        </body>
        </div>
    </main>

    <script src="home.js"></script>
</body>
</html>

