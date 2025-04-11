document.addEventListener('DOMContentLoaded', () => {
    // Payment Modal Logic
    const paymentMethodSelect = document.getElementById('payment-method');
    const upiSection = document.getElementById('upi-section');
    const paymentModal = document.getElementById('payment-modal');
    const paymentTotalElem = document.getElementById('payment-total');
    const paymentCloseBtn = document.querySelector('#payment-modal .close');
    const orderNowBtn = document.getElementById('order-now');
    const paymentForm = document.getElementById('payment-form');
    
    const orderSuccessModal = document.getElementById('order-success-modal');
    const orderSuccessCloseBtn = document.querySelector('#order-success-modal .close1');

    paymentMethodSelect.addEventListener('change', () => {
        if (paymentMethodSelect.value === 'upi') {
            upiSection.style.display = 'block';
        } else {
            upiSection.style.display = 'none';
        }
    });

    function openPaymentModal() {
        if (cart.length === 0) {
            alert("Please add at least one dish to the cart before proceeding to payment.");
        } else {
            paymentTotalElem.textContent = totalElem.textContent; // Set the total price in the payment modal
            paymentModal.style.display = 'flex'; // Show the payment modal
            sessionStorage.setItem('paymentModalOpen', 'true'); // Store state
        }
    }

    function closePaymentModal() {
        paymentModal.style.display = 'none';
        sessionStorage.removeItem('paymentModalOpen'); // Clear state when modal is closed
    }

    orderNowBtn.addEventListener('click', openPaymentModal);
    paymentCloseBtn.addEventListener('click', closePaymentModal);

    window.addEventListener('click', (event) => {
        if (event.target === paymentModal) {
            closePaymentModal();
        }
        if (event.target === cartModal) {
            closeCart();
        }
    });

    // Cart Modal Logic
    const cartBtn = document.getElementById('cart-btn');
    const cartModal = document.getElementById('cart-modal');
    const closeCartBtn = document.querySelector('#cart-modal .close');
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElem = document.getElementById('subtotal');
    const gstElem = document.getElementById('gst');
    const deliveryChargesElem = document.getElementById('delivery-charges');
    const totalElem = document.getElementById('total');
    let cart = [];

    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let subtotal = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <p>${item.name} ($${item.price})</p>
                    <div class="cart-quantity-control">
                        <button type="button" class="decrease-cart-quantity" data-dish-id="${item.id}">-</button>
                        <input type="number" value="${item.quantity}" min="1" readonly>
                        <button type="button" class="increase-cart-quantity" data-dish-id="${item.id}">+</button>
                    </div>
                    <p>Total: $${itemTotal.toFixed(2)}</p>
                </div>
            `;
        });

        const gst = subtotal * 0.10;
        const deliveryCharges = 50;
        const total = subtotal + gst + deliveryCharges;

        subtotalElem.textContent = subtotal.toFixed(2);
        gstElem.textContent = gst.toFixed(2);
        deliveryChargesElem.textContent = deliveryCharges.toFixed(2);
        totalElem.textContent = total.toFixed(2);

        attachQuantityControlListeners();
    }

    function attachQuantityControlListeners() {
        document.querySelectorAll('.increase-cart-quantity').forEach(button => {
            button.addEventListener('click', () => {
                const dishId = button.getAttribute('data-dish-id');
                const cartItem = cart.find(item => item.id === dishId);
                if (cartItem) {
                    cartItem.quantity += 1;
                    updateCart();
                }
            });
        });

        document.querySelectorAll('.decrease-cart-quantity').forEach(button => {
            button.addEventListener('click', () => {
                const dishId = button.getAttribute('data-dish-id');
                const cartItem = cart.find(item => item.id === dishId);
                if (cartItem && cartItem.quantity > 1) {
                    cartItem.quantity -= 1;
                    updateCart();
                }
            });
        });
    }

    function openCart() {
        cartModal.style.display = 'block';
        updateCart();
    }

    function closeCart() {
        cartModal.style.display = 'none';
    }

    cartBtn.addEventListener('click', openCart);
    closeCartBtn.addEventListener('click', closeCart);

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const form = button.closest('.dish-form');
            const dishId = button.getAttribute('data-dish-id');
            const dishPrice = parseFloat(form.getAttribute('data-dish-price'));
            const quantityInput = form.querySelector('input[name="quantity"]');
            const quantity = parseInt(quantityInput.value, 10);

            const dishItem = form.closest('.dish-item');
            const dishName = dishItem.querySelector('h3').textContent.trim();

            const existingDish = cart.find(item => item.id === dishId);

            if (!existingDish) {
                cart.push({
                    id: dishId,
                    name: dishName,
                    price: dishPrice,
                    quantity: quantity
                });
                button.textContent = 'Already Added';
            } else {
                button.textContent = 'Already Added';
            }

            updateCart();
        });
    });

    // Prevent form submission default behavior and handle form data submission
    paymentForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the default form submission

        const paymentMethod = paymentMethodSelect.value;
        const payerName = document.getElementById('payer-name').value;
        const payerAddress = document.getElementById('payer-address').value;
        const payerPhone = document.getElementById('payer-phone').value;
        const upiId = paymentMethod === 'upi' ? document.getElementById('upi-id').value : null;

        // Prepare data for submission
        const cartItems = cart.map(item => ({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity
        }));

        const paymentData = {
            paymentMethod: paymentMethod,
            payerName: payerName,
            payerAddress: payerAddress,
            payerPhone: payerPhone,
            upiId: upiId,
            totalAmount: totalElem.textContent,
            cartItems: cartItems // Include cart items in the payload
        };

        // Send data to server using fetch
        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(paymentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close both payment and cart modals
                closePaymentModal(); 
                closeCart();

                // Show the order success modal
                orderSuccessModal.style.display = 'flex';

                cart = []; // Clear cart
                updateCart(); // Update cart display
            } else {
                alert('Payment failed. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    // Close order success modal
    orderSuccessCloseBtn.addEventListener('click', () => {
        orderSuccessModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === orderSuccessModal) {
            orderSuccessModal.style.display = 'none';
        }
    });

    // Ensure the payment modal and order success modal are hidden on page load
    paymentModal.style.display = 'none';
    orderSuccessModal.style.display = 'none';
    cartModal.style.display = 'none'; // Hide the cart modal as well

    // Check if the payment modal was previously opened
    if (sessionStorage.getItem('paymentModalOpen') === 'true') {
        paymentModal.style.display = 'flex'; // Show modal
        sessionStorage.removeItem('paymentModalOpen'); // Clear state
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
