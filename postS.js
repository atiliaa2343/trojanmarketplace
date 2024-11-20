function displayCreatePost(){
    document.getElementById("createPostDiv").style.display="block";
    document.getElementById("homePageDiv").style.display="none";
}
function handleFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    const formData = new FormData(event.target);
    const insertImage = formData.get("insertImage").name;
    const TitleItem = formData.get("TitleItem");
    const conditionItem = formData.get("conditionItem");
    const priceItem = formData.get("priceItem");

    // Display the result
    document.getElementById("resultDiv").innerHTML = `
        <h2>Post Details</h2>
        <p>Image: ${insertImage}</p>
        <p>Title for post: ${TitleItem}</p>
        <p>Condition: ${conditionItem}</p>
        <p>Price for Item: ${priceItem}</p>
    `;
    document.getElementById("resultDiv").style.display = "block";
    document.getElementById("createPostDiv").style.display = "none";
}


// Add event listener to the form
document.getElementById("createPostForm").addEventListener("submit", handleFormSubmission);