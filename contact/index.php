<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Restaurant</div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../menu/index.php">Menu</a></li>
            <li><a href="../order/index.php">Order Online</a></li>

            <li><a href="../about/index.php"  >About</a></li>
            <li><a href="index.php" class="active">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <button class="signup-btn"><i class="bi bi-telephone-plus-fill"></i>Call Manager</button>
        </div>
    </nav>


    <body>
        <main>
            <section class="contact-header">
                <h1>Contact Us</h1>
                <p>We'd love to hear from you! Reach out to us through any of the methods below.</p>
            </section>
    
            <section class="contact-info">
                <div class="contact-item">
                    <h2>Our Address</h2>
                    <p>123 Main Street, Anytown, USA</p>
                </div>
                <div class="contact-item">
                    <h2>Phone</h2>
                    <p>+1 234 567 890</p>
                </div>
                <div class="contact-item">
                    <h2>Email</h2>
                    <p><a href="mailto:info@restaurant.com">info@restaurant.com</a></p>
                </div>
                <div class="contact-item">
                    <h2>Follow Us</h2>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </section>
    
            <section class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="#">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit">Send Message</button>
                </form>
            </section>
    
            <section class="location">
                <h2>Our Location</h2>
                <img src="../images/map.jpg" alt="Location Image">
            </section>
        </main>
    
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
    </body>
    </html>
    
   <script src="script.js"></script>
</body>
</html>