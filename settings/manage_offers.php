<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers</title>
  <style>
    /* Reset basic elements */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Background with a festive vibe */
body {
    background: url('../images/festival-bg.jpg') no-repeat center center/cover;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Container for the form (smaller and more compact) */
.offer-form {
    background: rgba(255, 255, 255, 0.85);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 100%;
    animation: zoomIn 0.8s ease;
    text-align: center;
    position: relative;
}

/* Decorative festive elements */
.offer-form:before {
    content: "";
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: url('../images/festive-decoration.jpg') no-repeat center;
    width: 100px;
    height: 35px;
}

/* Header with festive touch (smaller size) */
.offer-form h2 {
    font-size: 1.5rem;
    color: #f54b42;
    margin-bottom: 15px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    position: relative;
}

/* Decorative border under the header */
.offer-form h2:after {
    content: '';
    width: 40px;
    height: 3px;
    background-color: #f54b42;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -8px;
    border-radius: 2px;
}

/* Label and input field styling (smaller font and compact spacing) */
.offer-form label {
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 8px;
    display: block;
    text-align: left;
    margin-top: 10px;
    font-weight: 600;
}

.offer-form input[type="text"],
.offer-form input[type="number"],
.offer-form textarea,
.offer-form select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #333;
    background: rgba(255, 255, 255, 0.9);
    transition: border-color 0.4s ease;
}

/* Hover and focus effects */
.offer-form input[type="text"]:focus,
.offer-form input[type="number"]:focus,
.offer-form textarea:focus,
.offer-form select:focus {
    border-color: #f54b42;
    outline: none;
    box-shadow: 0 0 8px rgba(245, 75, 66, 0.5);
}

/* Textarea */
.offer-form textarea {
    height: 80px;
    resize: none;
}

/* Button styles (smaller and more compact) */
.offer-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    background: linear-gradient(135deg, #f54b42, #f0932b);
    color: #fff;
    font-size: 1rem;
    border-radius: 6px;
    margin-top: 15px;
    cursor: pointer;
    transition: background 0.4s ease, box-shadow 0.4s ease;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}

.offer-form input[type="submit"]:hover {
    background: linear-gradient(135deg, #f0932b, #f54b42);
    box-shadow: 0 4px 10px rgba(245, 75, 66, 0.4);
}

.offer-form input[type="submit"]:active {
    transform: scale(0.98);
}

/* Zoom in animation for form appearance */
@keyframes zoomIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* Media queries for mobile responsiveness */
@media screen and (max-width: 600px) {
    .offer-form {
        padding: 15px;
        max-width: 90%;
    }

    .offer-form h2 {
        font-size: 1.2rem;
    }

    .offer-form input[type="submit"] {
        font-size: 0.9rem;
    }
}
/* Back button styling */
.back-button {
    background: #ddd;
    color: #333;
    border: none;
    padding: 10px;
    font-size: 0.9rem;
    border-radius: 6px;
    margin-top: 15px;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    display: block;
    width: 100%;
}

.back-button:hover {
    background: #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.back-button:active {
    transform: scale(0.98);
}


  </style>
</head>
<body>
<div class="offer-form">
        <h2>Add New Offer</h2>
        <form action="add_offer.php" method="POST">
            <label for="offer-name">Offer Name:</label>
            <input type="text" id="offer-name" name="offer_name" required>

            <label for="offer-type">Offer Type:</label>
            <select id="offer-type" name="offer_type">
                <option value="card">Card Offer</option>
                <option value="family">Family Offer</option>
                <option value="discount">Discount</option>
                <option value="festival">Festival Event</option>
            </select>

            <label for="offer-percentage">Offer Percentage:</label>
            <input type="number" id="offer-percentage" name="offer_percentage" required>

            <label for="offer-details">Offer Details:</label>
            <textarea id="offer-details" name="offer_details"></textarea>

            <input type="submit" value="Add Offer">
            <button type="button" class="back-button" onclick="window.location.href='index.php'">Back to Settings</button>
        </form>
    </div>
</body>
</html>
