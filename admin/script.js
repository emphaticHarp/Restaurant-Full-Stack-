


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', () => {
            const tableId = button.getAttribute('data-table-id');
            
            fetch('reset_table.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    table_number: tableId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Table data reset successfully.');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        });
    });
});

// script.js
// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Delay to keep the loading screen visible for 1-2 seconds
    setTimeout(function() {
        document.body.classList.add('loaded');
    }, 1000); // Adjust the delay as needed (2000 milliseconds = 2 seconds)
});


// dish modal

// script.js

// Get the modal
var customModal = document.getElementById("addDishCustomModal");

// Get the button that opens the modal
var openModalBtn = document.getElementById("openModal");

// Get the <span> element that closes the modal
var closeModalSpan = document.getElementsByClassName("custom-close")[0];

// When the user clicks the button, open the modal
openModalBtn.onclick = function() {
    customModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeModalSpan.onclick = function() {
    customModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == customModal) {
        customModal.style.display = "none";
    }
}

// edit dish 
// Function to open the edit modal and fetch dish details
function openEditModal(dishId) {
    // Open modal
    document.getElementById('editDishModal').style.display = 'block';

    // Fetch dish details
    fetch(`get_dish_details.php?dish_id=${dishId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Log data to debug
            console.log(data);

            // Check for error in the data
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Populate modal fields with dish data
            document.getElementById('edit_dish_id').value = data.id || '';
            document.getElementById('edit_dish_name').value = data.name || '';
            document.getElementById('edit_category').value = data.category || '';
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_price').value = data.price || '';

            // Update the image
            const currentImage = document.getElementById('current_image');
            if (data.image) {
                currentImage.src = `../images/${data.image}`;
                currentImage.style.display = 'block';
            } else {
                currentImage.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching dish details:', error));
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById('editDishModal').style.display = 'none';
}

// Function to close the add dish modal
function closeAddDishModal() {
    document.getElementById('addDishCustomModal').style.display = 'none';
}

// Event listener to close the edit modal when the close button is clicked
document.querySelector('.custom-dish-modal .custom-close').addEventListener('click', closeEditModal);

// Event listener to close the add dish modal when the close button is clicked
document.querySelectorAll('#addDishCustomModal .custom-close')[0].addEventListener('click', closeAddDishModal);

// Event listener to open the add dish modal
document.getElementById('openModal').addEventListener('click', () => {
    document.getElementById('addDishCustomModal').style.display = 'block';
});

// Close modals when clicking outside the modal
window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('editDishModal')) {
        closeEditModal();
    } else if (event.target === document.getElementById('addDishCustomModal')) {
        closeAddDishModal();
    }
});





