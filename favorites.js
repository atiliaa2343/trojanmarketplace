document.addEventListener("DOMContentLoaded", function () {
    fetch('favorites.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data); // Debugging log

            const favoritesDisplay = document.getElementById('favorites-display');
            if (!favoritesDisplay) {
                console.error('Element with id "favorites-display" not found.');
                return;
            }

            if (data.length === 0) {
                favoritesDisplay.innerHTML += '<p>No items in your favorites.</p>';
                return;
            }

            data.forEach(item => {
                const itemCard = document.createElement('div');
                itemCard.className = 'item-card';
                itemCard.innerHTML = `
                    <img src="${item.image}" alt="${item.description}" class="item-image" />
                    <h3>${item.description}</h3>
                    <p>Price: $${item.price}</p>
                    <p>Condition: ${item.condition}</p>
                    <p>Date Added: ${new Date(item.date_time).toLocaleDateString()}</p>
                    <button class="remove-button" data-id="${item.item_id}">Remove from Favorites</button>
                `;
                favoritesDisplay.appendChild(itemCard);
            });

            document.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', function () {
                    const itemId = this.getAttribute('data-id');
                    console.log('Removing favorite with ID:', itemId); // Debugging log

                    fetch('remove_favorite.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `item_id=${itemId}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Response from remove_favorite.php:', data); // Debugging log
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Failed to remove item from favorites.');
                            }
                        })
                        .catch(error => {
                            console.error('Error during remove request:', error); // Debugging log
                        });
                });
            });
        })
        .catch(error => {
            console.error('Error fetching favorites:', error); // Debugging log
            const favoritesDisplay = document.getElementById('favorites-display');
            if (favoritesDisplay) {
                favoritesDisplay.innerHTML = '<p>Error loading favorites. Please try again later.</p>';
            }
        });
});
