document.addEventListener("DOMContentLoaded", () => {
    const categoryLinks = document.querySelectorAll(".categories li");

    // Fetch all items by default when the page loads
    fetchItemsByCategory();

    categoryLinks.forEach(link => {
        link.addEventListener("click", () => {
            const category = link.getAttribute("data-category");
            fetchItemsByCategory(category); // Pass the category to the function
        });
    });
});


function displayCreatePost() {
    document.getElementById("homePageDiv").style.display = "none";
    document.getElementById("createPostDiv").style.display = "block";
} 

function navigateToWelcomePage() {
    window.location.href = 'login-welcome/welcome.php'; // Replace with the correct path to your posts page
}

function fetchItemsByCategory(category = '') {
    const url = category ? `home.php?action=fetch&category=${category}` : 'home.php?action=fetch';

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(items => {
            displayItems(items);
        })
        .catch(error => {
            console.error("Error fetching items:", error);
        });
}

function displayItems(items) {
    const displaySection = document.getElementById('items-display');
    displaySection.innerHTML = '';

    if (items.length === 0) {
        displaySection.innerHTML = '<p>No items found.</p>';
        return;
    }

    items.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('post-item');
        itemDiv.innerHTML = `
            <img src="${item.image}" alt="${item.description}">
            <h5>Description: ${item.description}</h5>
            <p>Price: $${item.price}</p>
            <p>Condition: ${item.condition}</p>
        `;
        displaySection.appendChild(itemDiv);
    });
}

