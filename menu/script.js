function showItems(category) {
    // Add your logic to display items based on the category name
    console.log("Showing items for category: " + category);
    // Fetch and display the items for the selected category
}


document.addEventListener('DOMContentLoaded', () => {
    const menuDetails = document.getElementById('menu-details');
    const cartModal = document.getElementById('cartModal');
    const closeBtn = document.querySelector('.close');
    const paymentBtn = document.getElementById('submitOrder');
    const orderList = document.getElementById('orderList');
    const tableNumberInput = document.getElementById('table-number');
    const foodRequirementsInput = document.getElementById('food-requirements');
    const cartButton = document.getElementById('cart-button');

    let cartItems = [];

    // Show menu items based on category
    window.showItems = function(category) {
        menuDetails.innerHTML = '';

        fetch('fetch_dishes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ group: category })
        })
        .then(response => response.json())
        .then(items => {
            if (items.error) {
                menuDetails.innerHTML = `<p>${items.error}</p>`;
                return;
            }

            if (items.length === 0) {
                menuDetails.innerHTML = '<p>No items available for this category.</p>';
                return;
            }

            items.forEach(item => {
                const menuItem = document.createElement('div');
                menuItem.classList.add('menu-item');

                menuItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="item-details">
                        <h3>${item.name}</h3>
                        <p>${item.description}</p>
                        <p class="price">$${parseFloat(item.price).toFixed(2)}</p>
                        <div class="quantity-wrapper">
                            <label for="quantity-${item.name.replace(/\s+/g, '-')}">Quantity:</label>
                            <input type="number" id="quantity-${item.name.replace(/\s+/g, '-')}" name="quantity" min="1" max="10" value="1">
                            <input type="checkbox" id="item-${item.name.replace(/\s+/g, '-')}" name="menu-item" value="${item.name.replace(/\s+/g, '-')}" data-price="${parseFloat(item.price).toFixed(2)}">
                            <label class="checkbox-label" for="item-${item.name.replace(/\s+/g, '-')}">Add to order</label>
                        </div>
                    </div>
                `;

                menuDetails.appendChild(menuItem);
            });
        })
        .catch(error => {
            console.error('Error fetching menu items:', error);
            menuDetails.innerHTML = '<p>Error loading menu items. Please try again later.</p>';
        });
    };

    // Add selected items to the cart and show modal
    cartButton.addEventListener('click', () => {
        const selectedItems = document.querySelectorAll('input[name="menu-item"]:checked');
        cartItems = [];

        selectedItems.forEach(item => {
            const itemName = item.value.replace(/-/g, ' ');
            const quantity = document.getElementById(`quantity-${item.value}`).value;
            const price = parseFloat(item.getAttribute('data-price'));
            cartItems.push({ name: itemName, quantity: parseInt(quantity), price: price });
        });

        updateModal(cartItems);
        cartModal.style.display = 'block';
    });

    // Close the modal
    closeBtn.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === cartModal) {
            cartModal.style.display = 'none';
        }
    });

    // Submit the order
    paymentBtn.addEventListener('click', () => {
        const tableNumber = tableNumberInput.value.trim();
        const foodRequirements = foodRequirementsInput.value.trim();

        if (tableNumber === '') {
            alert('Table number is required.');
            return;
        }

        if (cartItems.length > 0) {
            fetch('insert_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    tableNumber: tableNumber,
                    orderDetails: cartItems.map(item => `${item.name} (x${item.quantity})`).join(', '),
                    foodRequirements: foodRequirements
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(`Order placed successfully for table ${tableNumber}`);
                    cartItems = [];
                    updateModal(cartItems);
                } else {
                    alert('Error placing order: ' + data.message);
                }
                cartModal.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while placing the order.');
            });
        } else {
            alert('No items in cart.');
        }
    });

    // Update the modal with order details
    function updateModal(items) {
        if (!orderList) {
            console.error('Order list element is missing.');
            return;
        }

        orderList.innerHTML = '';
        let subtotal = 0;

        items.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            const listItem = document.createElement('li');
            listItem.innerHTML = `<span>${item.name} (x${item.quantity})</span> <span>$${itemTotal.toFixed(2)}</span>`;
            orderList.appendChild(listItem);
        });

        const gst = subtotal * 0.10;
        const grandTotal = subtotal + gst;

        document.querySelector('.total-price').textContent = `$${subtotal.toFixed(2)}`;
        document.querySelector('.gst').textContent = `$${gst.toFixed(2)}`;
        document.querySelector('.grand-total').textContent = `$${grandTotal.toFixed(2)}`;
        paymentBtn.textContent = `Make Payment ($${grandTotal.toFixed(2)})`;
    }
});
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
