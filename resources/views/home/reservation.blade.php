<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - Resta</title>
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
                <li><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                <li><a href="{{ url('/#menu') }}" class="nav-link">Menu</a></li>
                <li><a href="{{ url('/#about') }}" class="nav-link">About</a></li>
                <li><a href="{{ url('/#service') }}" class="nav-link">Service</a></li>
                <li><a href="{{ route('reservation') }}" class="nav-link active">Reservation</a></li>
                <li><a href="{{ url('/#contact') }}" class="nav-link">Contact</a></li>
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

    <!-- Reservation Section -->
    <section class="reservation-section">
        <div class="container">
            <div class="reservation-header">
                <h1>Make a <span class="highlight">Reservation</span></h1>
                <p>Book your table and enjoy our delicious meals in a cozy atmosphere</p>
            </div>

            <div class="reservation-content">
                <div class="reservation-form-container">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-card">
                        <h2>Reservation Details</h2>
                        <form action="{{ route('reservation.store') }}" method="POST" class="reservation-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="your.email@example.com">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="+1 (555) 000-0000">
                                </div>
                                <div class="form-group">
                                    <label for="guests">Number of Guests *</label>
                                    <select id="guests" name="guests" required>
                                        <option value="">Select guests</option>
                                        <option value="1">1 Person</option>
                                        <option value="2">2 People</option>
                                        <option value="3">3 People</option>
                                        <option value="4">4 People</option>
                                        <option value="5">5 People</option>
                                        <option value="6">6 People</option>
                                        <option value="7+">7+ People</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="date">Reservation Date *</label>
                                    <input type="date" id="date" name="date" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="time">Reservation Time *</label>
                                    <input type="time" id="time" name="time" value="{{ old('time') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="occasion">Special Occasion (Optional)</label>
                                <select id="occasion" name="occasion">
                                    <option value="">Select occasion</option>
                                    <option value="birthday">Birthday</option>
                                    <option value="anniversary">Anniversary</option>
                                    <option value="business">Business Meeting</option>
                                    <option value="date">Date Night</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Special Requests (Optional)</label>
                                <textarea id="message" name="message" rows="4" placeholder="Any dietary restrictions, seating preferences, or special requirements...">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit">Confirm Reservation</button>
                        </form>
                    </div>
                </div>

                <div class="reservation-info">
                    <div class="info-card">
                        <h3>📍 Location</h3>
                        <p>123 Restaurant Street<br>Food District, City 12345</p>
                    </div>

                    <div class="info-card">
                        <h3>🕐 Opening Hours</h3>
                        <p>Monday - Friday: 11:00 AM - 10:00 PM<br>
                        Saturday - Sunday: 10:00 AM - 11:00 PM</p>
                    </div>

                    <div class="info-card">
                        <h3>📞 Contact</h3>
                        <p>Phone: +1 (555) 123-4567<br>
                        Email: info@restaaura.com</p>
                    </div>

                    <div class="info-card highlight-card">
                        <h3>💡 Reservation Tips</h3>
                        <ul>
                            <li>Book at least 24 hours in advance</li>
                            <li>Arrive 10 minutes early</li>
                            <li>Call us for groups of 8 or more</li>
                            <li>Cancellations are free up to 2 hours before</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2><span class="brand-fresh">Resta</span><span class="brand-aura">Aura</span></h2>
                    <p>Fresh Flavors, Warm Hospitality</p>
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
                        <h4>Follow Us</h4>
                        <ul>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">LinkedIn</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>