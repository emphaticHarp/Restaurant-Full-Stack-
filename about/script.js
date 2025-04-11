// Function to show loader for a specific duration
function showLoaderWithDuration(duration) {
    // Show the loader
    document.getElementById("loaderModal").style.display = "flex";

    // Hide the loader after the specified duration (in milliseconds)
    setTimeout(function () {
        document.getElementById("loaderModal").style.display = "none";
    }, duration); // duration is in milliseconds
}

// Example: Show loader for 5 seconds (5000 milliseconds)
showLoaderWithDuration(3000);
