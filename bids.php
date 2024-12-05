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

// Initialize the bids array
$bids = []; 
$item_id = null; 

// Check if item_id is provided in the URL
if (isset($_GET['item_id']) && !empty($_GET['item_id'])) {
    $item_id = $_GET['item_id'];

    // Query to fetch bids with item and student details for a specific item_id
    $sql = "SELECT Bids.bid_id, Bids.student_id, Bids.item_id, 
                   Items.image, Items.price, Items.description, Items.`condition`,
                   Students.first_name, Students.last_name, Students.email
            FROM Bids
            JOIN Items ON Bids.item_id = Items.item_id
            JOIN Students ON Bids.student_id = Students.student_id
            WHERE Bids.item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // Query to fetch all bids with item and student details
    $sql = "SELECT Bids.bid_id, Bids.student_id, Bids.item_id, 
                   Items.image, Items.price, Items.description, Items.`condition`,
                   Students.first_name, Students.last_name, Students.email
            FROM Bids
            JOIN Items ON Bids.item_id = Items.item_id
            JOIN Students ON Bids.student_id = Students.student_id";
    $result = $conn->query($sql);
}

// Fetch results into the $bids array
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
        $bids[] = $row;
    }  
}

?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Trojan Marketplace - Bids</title> 
    <link rel="stylesheet" href="home.css"> 

    <!-- Font Awesome Icons--> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head> 
<body>  

    <header class="navbar">   
        <div class="logo">
            <img src="vsu.png" alt="Logo"> 
        </div>
        <div class="navbar-title"> 
            Trojan Marketplace - Bids
        </div>  
        <input type="text" placeholder="Search on Trojan Marketplace" class="search-bar">
        <div class="navbar-buttons">  
            <button class="navbar-button">Create A Post</button>
        </div> 
        <div class="navbar-buttons">  
            <button class="navbar-button">Sign Up</button> 
        </div> 
    </header>  

    <!-- Main Content --> 
    <main>   
        <div class="nav-icons"> 
            <!-- Home -->
            <a href="home.php" class="icon-btn" title="Home"> 
                <i class="fa-solid fa-house"></i>
            </a>  
            <!-- Messages -->
            <a href="#" class="icon-btn" title="Messages"> 
                <i class="fa-solid fa-envelope"></i>
            </a> 
            <!-- Bids -->
            <a href="bids.php" class="icon-btn" title="Bids"> 
                <i class="fa-solid fa-gavel"></i>
            </a> 
            <!-- Favorites -->
            <a href="#" class="icon-btn" title="Favorites"> 
                <i class="fa-solid fa-heart"></i>
            </a>
        </div>

        <section id="bids-display" class="posts-grid">
            <?php if ($item_id !== null): ?>
                <h3>Bids for Item ID: <?php echo htmlspecialchars($item_id); ?></h3>
            <?php else: ?>
                <h3>All Bids</h3>
            <?php endif; ?>

            <?php if (empty($bids)) : ?>
                <p>No bids available.</p>
            <?php else : ?>
                <?php foreach ($bids as $bid) : ?>
                    <div class="post-item">
                        <a href="item.php?id=<?php echo htmlspecialchars($bid['item_id']); ?>" class="item-link">
                            <img src="<?php echo htmlspecialchars($bid['image']); ?>" alt="<?php echo htmlspecialchars($bid['description']); ?>" />
                            <h5><?php echo htmlspecialchars($bid['description']); ?></h5>
                            <p><strong>Condition:</strong> <?php echo htmlspecialchars($bid['condition']); ?></p>
                            <button class="bid-button" onclick="placeBid(<?php echo htmlspecialchars($bid['item_id']); ?>)">
                                Bid ($<?php echo htmlspecialchars($bid['price']); ?>)
                            </button>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <script>
        srcipt src="bids.php"
    </script>

</body>
</html>
