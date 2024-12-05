//Event Listener for the "Clothes" category 
document.addEventListener("DOMContentLoaded", () => { 
    const categoryLinks = document.querySelectorAll(".categories li"); 
    
    categoryLinks.forEach(link => { 
        link.addEventListener("click", () => {
            const category = link.getAttribute("data-category"); 
            fetchItemsByCategory(category);
    
            });
        });

});  

function fetchItemsByCategory(category) { 
    fetch(`home.php?category=${category}`) 
        .then(response => { 
            if (!response.ok) { 
                throw new Error('Network response was not ok')
            } 
            return response.json();
        })
        .then(items => displayItems(items)) 
        .catch(error => console.error("Error fetching items:", error));
}

//Function to display items on the page 
function displayItems(items) { 
    const displaySection = document.getElementById('items-display'); 
    displaySection.innerHTML = ''; 
    items.forEach(item => { 
        const itemDiv = document.createElement('div'); 
        itemDiv.classList.add('item', "post-item"); 
        itemDiv.innerHTML = `  
        <a href = "item.php?id=${item.item_id}" class = "item-link">
        <img src="${item.image}" alt="${item.description}"> 
        <h5>Description: ${item.description}</h5> 
        <p>Price: $${item.price}</p> 
        <p>Condition: ${item.condition}</p> 
        <p>Date Listed: ${item.date_time}</p>` 
        ; 
        displaySection.appendChild(itemDiv);
    }); 
    
}