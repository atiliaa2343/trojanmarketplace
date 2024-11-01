<?php 

$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "trojanmarketplace";  

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname); 

//Check connection
if ($conn->connect_error) { 
    die("Connection failed: ". $conn->connect_error); 
} 

// Query items in clothes category

if(isset($_GET['category'])) { 
    $category = $_GET['category'];
$sql = "SELECT item_id, image, price, description, `condition`, date_time 
        FROM Items 
        JOIN Categories ON Items.category_id = Categories.category_id 
        WHERE Categories.category_name = '$category'";  
$result = $conn->query($sql); 
$items = []; 

if($result->num_rows > 0) {
while ($row = $result ->fetch_assoc()) { 
    $items[] = $row;
} 
echo json_encode($items); 
exit;
} 
}
?>
<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name = "viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Trojan Marketplace</title> 
        <link rel="stylesheet" href="home.css"> 

        <!-- Font Awesome Icons--> 
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head> 
    <body>  

        <header class = "navbar">   
            <div class = "logo">
                <img src = "vsu.png" alt="Logo"> 
            </div>
        
        <div class = "navbar-title"> 
            Trojan Marketplace
        </div>  
        <input type = "text" placeholder="Search on Trojan Marketplace" class = "search-bar">
        <div class = "navbar-buttons">  
            <button class = "navbar-button">Create A Post</button>
        </div> 
        <div class = "navbar-buttons">  
            <button class = "navbar-button">Sign Up</button> 
        </div> 
        </header>  

        <!-- Main Content --> 
         <main>   

             <!-- Icon Links --> 
         <div class="nav-icons"> 
            <!-- Home -->
            <a href="#" class="icon-btn" title="Home"> 
               <i class="fa-solid fa-house"></i>
           </a>  
           <!-- Messages -->
           <a href="#" class="icon-btn" title="Messages"> 
               <i class="fa-solid fa-envelope"></i>
           </a> 
            <!-- Bids -->
            <a href="#" class="icon-btn" title="Messages"> 
               <i class="fa-solid fa-gavel"></i>
           </a> 
           <!-- Favorites -->
           <a href="#" class="icon-btn" title="Messages"> 
               <i class="fa-solid fa-heart"></i>
           </a>
        </div>
  
            <aside class = "sidebar"> 
                <h3>Today's Picks</h3> 
                <div class = "price-filter"> 
                    <label>Price $</label> 
                    <input type="number" placeholder="Min"> 
                    <input type="number" placeholder="Max"> 

                </div> 

                <h4>Product Categories</h4> 
                <!-- Categories pulled from database --> 
                 <ul class="categories"> 
                    <li id ="clothes-category" data-category = "Clothes" role="button">Clothes</li> 
                    <li data-category = "Shoes" role="button">Shoes</li> 
                    <li data-category = "Lifestyle" role="button">Lifestyle</li> 
                    <li data-category = "Home Goods" role="button">Home Goods</li> 
                    <li data-category = "Vehicles" role="button">Vehicles</li> 
                    <li data-category = "Miscellaneous" role="button">Miscellaneous</li>
                 </ul>
            </aside>  
            <section id="items-display" class="posts-grid"></section>


            
         </main>
        <script src = "home.js"></script>
    </body>
</html>