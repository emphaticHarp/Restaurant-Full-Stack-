<?php
// Start the session
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Restaurant</div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="menu/index.php">Menu</a></li>
            <li><a href="order/index.php">Order Online</a></li>
            <li><a href="about/index.php">About</a></li>
            <li><a href="contact/index.php">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <button class="signup-btn"><i class="bi bi-telephone-plus-fill"></i>Call Manager</button>
        </div>
    </nav>


    <!-- Loader Modal -->
<div id="loaderModal" class="loader-modal">
    <div class="loader-modal-content">
        <dotlottie-player src="https://lottie.host/40d386b6-04cf-4aec-b498-b68cdd769814/P7N5D5g5Ks.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
        <p>Loading, please wait...</p>
    </div>
</div>

    <header>
        <h1>Welcome to Our Restaurant</h1>
        <p>Delicious food, delivered to you</p>
    </header>


    <!-- <div id="shutdownModal" class="shutdown-modal">
    <div class="shutdown-modal-content">
    <dotlottie-player src="https://lottie.host/f26df19a-8d7f-4adf-bc50-fedbc2ea5aab/KS6VP20dZW.json" background="transparent" speed="1" style="width: 200px; margin-left: 200px; height: 200px;" loop autoplay></dotlottie-player>
        
        <h2>Website is Down for Maintenance</h2>
        <p>The website is currently undergoing maintenance. Please check back later.</p>
    </div>
</div> -->

<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <section id="food-selection" class="container">
        <h2>Our Favorite Dishes</h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/chicken.png" alt="Biriyani">
                        <h3>Biriyani</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/juice.png" alt="Chicken">
                        <h3>Juices</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/momo.png" alt="Vegetarian">
                        <h3>Momo</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/omlet.png" alt="Monaco">
                        <h3>Omlet</h3>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/sandwich.png" alt="Monaco">
                        <h3>Sandwich</h3>
                    </div>
                </div>  <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/south.png" alt="Monaco">
                        <h3>Thali</h3>
                    </div>
                </div>  <div class="swiper-slide">
                    <div class="food-item">
                        <img src="images/mutton.png" alt="Monaco">
                        <h3>Mutton</h3>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

<!-- about -->
    <section id="about-us" class="container">
        <h2>Our Dining Rooms</h2>
        <div class="about-content">
            <div class="about-image">
                <img src="images/about-1.jpg" alt="Image 1">
            </div>
            <div class="about-image">
                <img src="images/about-2.jpg" alt="Image 2">
            </div>
            <div class="about-image">
                <img src="images/about-3.jpg" alt="Image 3">
            </div>
            <div class="about-image">
                <img src="images/about-4.jpg" alt="Image 4">
            </div>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a nisl ut ipsum interdum laoreet. Proin id urna vel odio convallis feugiat.</p>
        <div class="about-stats">
            <div class="stat">
                <h3>10+</h3>
                <p>Years of Experience</p>
            </div>
            <div class="stat">
                <h3>25+</h3>
                <p>Popular Chefs</p>
            </div>
        </div>
        <a href="about/index.php" class="read-more-btn"><span>Read More</span></a>

        
    </section>
    <!-- food menu -->
    <section id="food-menu" class="container">
        <h2>Food Menu</h2>
        <div class="menu-tabs">
            <button class="tab-button active" onclick="showMenu('breakfast')">Breakfast</button>
            <button class="tab-button" onclick="showMenu('lunch')">Lunch</button>
            <button class="tab-button" onclick="showMenu('dinner')">Dinner</button>
        </div>
        <div id="breakfast" class="menu-content">
            <!-- Breakfast items here -->
            <div class="item">
                <img src="images/2.png" alt="Breakfast 1">
                <h3>Pancakes</h3>
                <p>Delicious fluffy pancakes with syrup.</p>
                <div class="price">$5.99</div>
            </div>
            <div class="item">
                <img src="images/omlet.png" alt="Breakfast 2">
                <h3>Omelette</h3>
                <p>Cheese omelette with vegetables.</p>
                <div class="price">$6.99</div>
            </div>
            <!-- Add more items as needed -->
        </div>
        <div id="lunch" class="menu-content" style="display: none;">
            <!-- Lunch items here -->
            <div class="item">
                <img src="images/3.png" alt="Lunch 1">
                <h3>Grilled Chicken</h3>
                <p>Juicy grilled chicken with salad.</p>
                <div class="price">$10.99</div>
            </div>
            <div class="item">
                <img src="images/4.png" alt="Lunch 2">
                <h3>Burger</h3>
                <p>Beef burger with cheese and fries.</p>
                <div class="price">$8.99</div>
            </div>
            <!-- Add more items as needed -->
        </div>
        <div id="dinner" class="menu-content" style="display: none;">
            <!-- Dinner items here -->
            <div class="item">
                <img src="images/5.png" alt="Dinner 1">
                <h3>Steak</h3>
                <p>Grilled steak with mashed potatoes.</p>
                <div class="price">$15.99</div>
            </div>
            <div class="item">
                <img src="images/1.png" alt="Dinner 2">
                <h3>Seafood Platter</h3>
                <p>Assorted seafood with garlic sauce.</p>
                <div class="price">$18.99</div>
            </div>
           
            <!-- Add more items as needed -->
        </div>
        <a href="menu/index.php" class="more-chefs">And many more food Items🤤</a>
    </section>
    
    <!-- chef -->

    <section id="top-chefs" class="container">
        <h2>Top Chefs</h2>
        <div class="chef-items">
            <div class="chef-item">
                <img src="images/team-1.jpg" alt="Chef 1">
                <h3>Chef John Doe</h3>
                <p>Head Chef</p>
            </div>
            <div class="chef-item">
                <img src="images/team-2.jpg" alt="Chef 2">
                <h3>Chef Jane Smith</h3>
                <p>Pastry Chef</p>
            </div>
            <div class="chef-item">
                <img src="images/team-3.jpg" alt="Chef 3">
                <h3>Chef Bob Brown</h3>
                <p>Sous Chef</p>
            </div>
            <p class="more-chefs">And many more chefs from all over the world</p>
      
        </div>
    </section>

    <!-- testimonials -->

    <section id="testimonials" class="container">
        <h2>What Our Clients Say</h2>
        <div class="testimonial-slider">
            <div class="testimonial-item">
                <img src="images/testimonial-1.jpg" alt="Client 1">
                <p>"The food was absolutely amazing, and the service was top-notch! Highly recommend."</p>
                <h3>John Doe</h3>
                <p>Food Lover</p>
            </div>
            <div class="testimonial-item">
                <img src="images/testimonial-2.jpg" alt="Client 2">
                <p>"A delightful dining experience with an exquisite menu. Will definitely come back."</p>
                <h3>Jane Smith</h3>
                <p>Chef</p>
            </div>
            <div class="testimonial-item">
                <img src="images/testimonial-3.jpg" alt="Client 3">
                <p>"The ambiance and food quality are simply unparalleled. A must-visit for food enthusiasts."</p>
                <h3>Emily Johnson</h3>
                <p>Restaurant Critic</p>
            </div>
            <div class="testimonial-item">
                <img src="images/testimonial-4.jpg" alt="Client 4">
                <p>"Exceptional service and delicious meals. The best place to celebrate special occasions."</p>
                <h3>Michael Brown</h3>
                <p>Event Planner</p>
            </div>
            <div class="testimonial-item">
                <img src="images/testimonial-5.jpg" alt="Client 4">
                <p>"Exceptional service and delicious meals. The best place to celebrate special occasions."</p>
                <h3>Michael Brown</h3>
                <p>Event Planner</p>
            </div>
        </div>
        <div class="slider-controls">
            <button class="prev-slide">&#10094;</button>
            <button class="next-slide">&#10095;</button>
        </div>
    </section>

    <!-- book -->

    <section id="book-table">
        <h2>Book A Table</h2>
        <p>Reserve your table easily with us.</p>
        <div id="booking-container">
            <div id="booking-image">
                <img src="images/about-1.jpg" alt="Restaurant Image">
            </div>
            <div id="booking-form-container">
                <form id="booking-form">
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="Your Name" required >
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Your Email" required >
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" placeholder="Your Phone" required >
                    </div>
                    <div class="form-group">
                        <input type="number" id="guests" name="guests" placeholder="No. of Members"  required min="1">
                    </div>
                    <div class="form-group">
                        <input type="date" id= "date" name="date" placeholder="Date" required >
                    </div>
                    <div class="form-group">
                        <input type="time" id= "time" name="time" placeholder="Time" required >
                    </div>
                    <button type="submit">Book Now</button>
                </form>
            </div>
        </div>
    </section>

      <!-- Modal -->
      <div id="thankYouModal" class="modal">
        <div class="modal-content">
        <div class="modal-emoji">🎉</div>
            <h3>Thank you for your reservation!</h3>
            <p>Your reservation tickets will be sent to your desired email address.</p>
            <button class="close-btn">Close</button>
        </div>
    </div>

    <!-- footer -->

    <footer id="footer">
        <div class="footer-container">
            <div class="footer-section company">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h3>Contact</h3>
                <ul>
                    <li><a href="mailto:info@example.com">info@example.com</a></li>
                    <li><a href="tel:+123456789">+1 (234) 567-89</a></li>
                    <li><a href="#">1234 Street Name, City, Country</a></li>
                </ul>
            </div>
            <div class="footer-section newsletter">
                <h3>Newsletter</h3>
                <p>Subscribe to our newsletter to stay updated with our latest news and offers.</p>
                <form id="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <script src="script.js"></script>
</body>
</html>
