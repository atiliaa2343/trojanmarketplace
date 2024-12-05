document.addEventListener("DOMContentLoaded", () => {
    // Automatically fetch and display all bids when the page loads
    fetchBids();
});

// Function to fetch bids via AJAX
function fetchBids() {
    const url = 'bids.php'; // Ensure this is the correct file path

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            return response.json();
        })
        .then(bids => {
            console.log("Fetched bids:", bids); // Debugging: log bids to console
            displayBids(bids);
        })
        .catch(error => {
            console.error("Error fetching bids:", error);
            document.getElementById('bids-display').innerHTML = '<p>Error loading bids. Please try again later.</p>';
        });
}

// Function to display bids on the page
function displayBids(bids) {
    const bidsDisplay = document.getElementById('bids-display');
    bidsDisplay.innerHTML = ''; // Clear any existing content

    if (bids.length === 0) {
        bidsDisplay.innerHTML = '<p>No bids available.</p>';
        return;
    }

    bids.forEach(bid => {
        const bidDiv = document.createElement('div');
        bidDiv.classList.add('bid-item');
        bidDiv.innerHTML = `
            <div class="bid-details">
                <p><strong>Bid ID:</strong> ${bid.bid_id}</p>
                <p><strong>Student ID:</strong> ${bid.student_id}</p>
                <p><strong>Item ID:</strong> ${bid.item_id}</p>
            </div>
        `;
        bidsDisplay.appendChild(bidDiv);
    });
}
