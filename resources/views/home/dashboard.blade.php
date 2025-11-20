<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resta - Fresh Flavors, Warm Hospitality</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <span class="brand-fresh">Resta</span><span class="brand-aura">Aura</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active">Home</a></li>
                <li><a href="#menu" class="nav-link">Menu</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#service" class="nav-link">Service</a></li>
                <li><a href="{{route('reservation')}}" class="nav-link">Reservation</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                @else
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Fresh Flavors,<br>
                        Warm <span class="highlight">Hospitality</span>
                    </h1>
                    <div class="hero-features">
                        <div class="feature-item">
                            <div class="feature-icon">🍽️</div>
                            <span>Delicious Food</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🚚</div>
                            <span>Enjoyable Delivery</span>
                        </div>
                    </div>
                    <div class="hero-footer">
                        <div class="team-images">
                            <img src="https://via.placeholder.com/40" alt="Team member" class="team-img">
                            <img src="https://via.placeholder.com/40" alt="Team member" class="team-img">
                            <img src="https://via.placeholder.com/40" alt="Team member" class="team-img">
                            <img src="https://via.placeholder.com/40" alt="Team member" class="team-img">
                        </div>
                        <p class="team-text">Our Happy Customers</p>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="food-card">
                       <img src="{{ asset('storage//images/noodles.jpg')}}" alt="Pasta" class="main-dish">
                    </div>
                    <div class="side-card">
                        <img src="https://via.placeholder.com/100" alt="Salad" class="side-dish">
                        <div class="side-text">
                            <h4>Full Green Vegetable</h4>
                            <p>Vegetables are parts of plants that are consumed by humans</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Icons -->
    <section class="category-icons">
        <div class="container">
            <div class="icon-group">
                <div class="category-icon">
                    <span class="icon">🍳</span>
                    <h4>Breakfast</h4>
                    <p>Start your day with our delicious breakfast options</p>
                </div>
                <div class="category-icon">
                    <span class="icon">🍝</span>
                    <h4>Main Dish</h4>
                    <p>Explore our variety of main course dishes</p>
                </div>
                <div class="category-icon">
                    <span class="icon">🥤</span>
                    <h4>Drinks</h4>
                    <p>Refresh yourself with our beverage selection</p>
                </div>
                <div class="category-icon">
                    <span class="icon">🍰</span>
                    <h4>Desserts</h4>
                    <p>Indulge in our sweet treats</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Menu Section -->
    <section id="menu" class="menu-section">
        <div class="container">
            <div class="section-header">
                <h2>Special <span class="highlight">Menu</span></h2>
                <div class="filter-buttons">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Breakfast</button>
                    <button class="filter-btn">Lunch</button>
                    <button class="filter-btn">Dessert</button>
                    <button class="filter-btn">Drinks</button>
                </div>
            </div>
            <div class="menu-grid">
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Salmon Fry">
                    <h3>Salmon Fry</h3>
                    <p>Indonesian - Spicy - 880 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 5.00</span>
                    </div>
                </div>
                <div class="menu-card featured">
                    <span class="badge">Popular</span>
                    <img src="https://via.placeholder.com/250" alt="Thai Noodles">
                    <h3>Thai Noodles</h3>
                    <p>Thai - Medium Spicy - 650 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 7.50</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Curry Chicken">
                    <h3>Curry Chicken</h3>
                    <p>Indian - Spicy - 720 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 6.80</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Chicken Biryani">
                    <h3>Chicken Biryani</h3>
                    <p>Pakistani - Medium - 850 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 8.50</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Burger Plate">
                    <h3>Burger Plate</h3>
                    <p>American - 900 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 9.20</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Shawarma Platter">
                    <h3>Shawarma Platter</h3>
                    <p>Lebanese - 680 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 7.00</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Falafel Wrap">
                    <h3>Falafel Wrap</h3>
                    <p>Mediterranean - 550 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 6.50</span>
                    </div>
                </div>
                <div class="menu-card">
                    <img src="https://via.placeholder.com/250" alt="Chapli Kebab">
                    <h3>Chapli Kebab</h3>
                    <p>Pakistani - Spicy - 780 CAL</p>
                    <div class="card-footer">
                        <span class="price">$ 8.00</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="about" class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-box">
                    <span class="feature-number">01</span>
                    <h3>Healthy Ingredients</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc et est varius.</p>
                </div>
                <div class="feature-box">
                    <span class="feature-number">02</span>
                    <h3>Authentic Taste</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc et est varius.</p>
                </div>
            </div>
            <div class="feature-image">
                <img src="https://via.placeholder.com/600x300" alt="Delicious Food">
            </div>
            <div class="features-grid">
                <div class="feature-box">
                    <span class="feature-number">03</span>
                    <h3>Affordable Prices</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc et est varius.</p>
                </div>
                <div class="feature-box">
                    <span class="feature-number">04</span>
                    <h3>Fast Service</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc et est varius.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Healthy Food Section -->
    <section class="healthy-section">
        <div class="container">
            <h2 class="text-center">Healthy Food for<br><span class="highlight">Happy Minds</span></h2>
        </div>
    </section>

    <!-- Video & Promo Section -->
    <section id="service" class="promo-section">
        <div class="container">
            <div class="promo-grid">
                <div class="video-card">
                    <img src="https://via.placeholder.com/400x250" alt="Restaurant">
                    <div class="play-button">▶</div>
                    <h3>Where Good Food Happened</h3>
                </div>
                <div class="promo-text">
                    <h2>Highly Rated <span class="highlight">Eats</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod nunc et est varius, eget hendrerit enim blandit. Praesent tristique turpis et accumsan pharetra.</p>
                </div>
            </div>
            <div class="promo-grid reverse">
                <div class="offer-card">
                    <img src="https://via.placeholder.com/300" alt="Pizza">
                    <h2 class="offer-text">50% Offer</h2>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
                <div class="countdown-card">
                    <h3>Tasty Food</h3>
                    <div class="countdown">
                        <div class="time-box">
                            <span class="time-num">03</span>
                            <span class="time-label">Days</span>
                        </div>
                        <span class="separator">:</span>
                        <div class="time-box">
                            <span class="time-num">12</span>
                            <span class="time-label">Hours</span>
                        </div>
                        <span class="separator">:</span>
                        <div class="time-box">
                            <span class="time-num">40</span>
                            <span class="time-label">Mins</span>
                        </div>
                        <span class="separator">:</span>
                        <div class="time-box">
                            <span class="time-num">34</span>
                            <span class="time-label">Secs</span>
                        </div>
                    </div>
                </div>
                <div class="burger-card">
                    <img src="https://via.placeholder.com/300" alt="Burger">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <h2 class="text-center">Explore Our New <span class="highlight">Categories</span></h2>
            <div class="categories-grid">
                <div class="category-card">
                    <img src="https://via.placeholder.com/250" alt="Sweet Dessert">
                    <h3>Sweet Dessert's Side</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="category-card">
                    <img src="https://via.placeholder.com/250" alt="Sea Food">
                    <h3>Sea Food's Side</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="category-card">
                    <img src="https://via.placeholder.com/250" alt="Chinese Food">
                    <h3>Chinese Food's Side</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="text-center">They Loves Our Food</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p>"Hi this was really special, specially their one service which they never leave the table, every time just check if you want anything or not."</p>
                    <div class="reviewer">
                        <img src="https://via.placeholder.com/50" alt="Alicia Martinez">
                        <div>
                            <h4>Alicia Martinez</h4>
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p>"My friends are genuinely impressed with the quality of service and the food here. What they never leave all the time was the service quality."</p>
                    <div class="reviewer">
                        <img src="https://via.placeholder.com/50" alt="Maria Martinez">
                        <div>
                            <h4>Maria Martinez</h4>
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p>"My kids love everything organized here and specially the cleanliness. The food is amazing. They love coming here every week."</p>
                    <div class="reviewer">
                        <img src="https://via.placeholder.com/50" alt="John Madurai">
                        <div>
                            <h4>John Madurai</h4>
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="https://via.placeholder.com/150" alt="Food">
                    <h2><span class="brand-fresh">Resta</span><span class="brand-aura">Aura</span></h2>
                </div>
                <div class="footer-links">
                    <div class="link-group">
                        <h4>Company Info</h4>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Career</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="link-group">
                        <h4>Customer Help</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Terms</a></li>
                        </ul>
                    </div>
                    <div class="link-group">
                        <h4>Company Policy</h4>
                        <ul>
                            <li><a href="#">Policy</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Refund</a></li>
                            <li><a href="#">Shipping</a></li>
                        </ul>
                    </div>
                    <div class="link-group">
                        <h4>Stay Up To Date Newsletters</h4>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Your email">
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>