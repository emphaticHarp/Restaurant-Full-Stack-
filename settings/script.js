const toggleModeBtn = document.getElementById('toggle-dark-mode');
toggleModeBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    if (document.body.classList.contains('dark-mode')) {
        toggleModeBtn.innerHTML = '<i class="bi bi-sun"></i> ';
    } else {
        toggleModeBtn.innerHTML = '<i class="bi bi-moon"></i> ';
    }
});

// Initialize the slider based on localStorage state
document.addEventListener('DOMContentLoaded', function() {
    var shutdownToggle = document.getElementById('shutdownToggle');
    var toggleLabel = document.getElementById('toggleLabel');

    // Check if shutdown is already enabled
    if (localStorage.getItem('shutdown') === 'true') {
        shutdownToggle.checked = true;
        toggleLabel.textContent = "Resume Webpage";
    }

    // Listen for toggle state change
    shutdownToggle.addEventListener('change', function() {
        if (shutdownToggle.checked) {
            // Set shutdown in localStorage
            localStorage.setItem('shutdown', 'true');
            toggleLabel.textContent = "Resume Webpage";
            alert('Website is now in shutdown mode.');
        } else {
            // Set resume in localStorage
            localStorage.setItem('shutdown', 'false');
            toggleLabel.textContent = "Shut Down Webpage";
            alert('Website is now resumed.');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Delay to keep the loading screen visible for 1-2 seconds
    setTimeout(function() {
        document.body.classList.add('loaded');
    }, 1000); // Adjust the delay as needed (2000 milliseconds = 2 seconds)
});


