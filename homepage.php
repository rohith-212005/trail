<?php
session_start();
include 'includes/mongodb_api.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Additional CSS for Flight Results */
        .flight-result {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .flight-card {
            display: flex;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
        }

        .airline-logo {
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }

        .flight-details {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: center;
        }

        .flight-time, .flight-route, .flight-duration, .price {
            display: block;
            font-size: 14px;
        }

        .price {
            font-weight: bold;
            color: #007bff;
        }

        .view-prices {
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-prices:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="Travelmate_logo.png" alt="Travel Booking Logo" class="logo">
        </div>
        <div class="navbar-menu">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</span>
            <a href="logout.php">Logout</a>
            <a href="#">IN | ENG | USD</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Book Your Journey</h1>
        <p>Explore the world with our seamless booking experience.</p>
    </header>

    <!-- Booking Categories Section -->
    <div class="booking-categories">
        <div class="category" onclick="showSection('flights')">
            <i class="fas fa-plane"></i>
            <span>Flights</span>
        </div>
        <div class="category" onclick="showSection('hotels')">
            <i class="fas fa-hotel"></i>
            <span>Hotels</span>
        </div>
        <div class="category" onclick="showSection('cabs')">
            <i class="fas fa-car"></i>
            <span>Cabs</span>
        </div>
        <div class="category" onclick="showSection('trains')">
            <i class="fas fa-train"></i>
            <span>Trains</span>
        </div>
        <div class="category" onclick="showSection('buses')">
            <i class="fas fa-bus"></i>
            <span>Buses</span>
        </div>
    </div>

    <!-- Search Form for Flights -->
    <div class="search-form" id="flights">
        <h2>Search Flights</h2>
        <form>
            <div class="form-group">
                <label for="flight-from">From:</label>
                <input type="text" id="flight-from" name="flight_from" placeholder="City or Airport">
            </div>
            <div class="form-group">
                <label for="flight-to">To:</label>
                <input type="text" id="flight-to" name="flight_to" placeholder="City or Airport">
            </div>
            <div class="form-group">
                <label for="flight-departure">Departure:</label>
                <input type="date" id="flight-departure" name="flight_departure">
            </div>
            <a href="flights.html"><button type="button" onclick="showResults('flights')">Search</button> </a>


        </form>
    </div>

    <!-- Search Form for Hotels -->
    <div class="search-form" id="hotels" style="display: none;">
        <h2>Search Hotels</h2>
        <form>
            <div class="form-group">
                <label for="hotel-location">Location:</label>
                <input type="text" id="hotel-location" placeholder="City or Hotel Name">
            </div>
            <div class="form-group">
                <label for="checkin">Check-In:</label>
                <input type="date" id="checkin">
            </div>
            <div class="form-group">
                <label for="checkout">Check-Out:</label>
                <input type="date" id="checkout">
            </div>
            <div class="form-group">
                <label for="hotel-guests">Guests:</label>
                <input type="number" id="hotel-guests" placeholder="Number of Guests" min="1">
            </div>
            <a href="hotals.html"><button type="button" onclick="showResults('hotels')">Search</button></a>
        </form>
    </div>

    <!-- Search Form for Cabs -->
    <div class="search-form" id="cabs" style="display: none;">
        <h2>Search Cabs</h2>
        <form>
            <div class="form-group">
                <label for="cab-location">Pick-Up Location:</label>
                <input type="text" id="cab-location" placeholder="Location">
            </div>
            <div class="form-group">
                <label for="cab-drop">Drop Location:</label>
                <input type="text" id="cab-drop" placeholder="Location">
            </div>
            <div class="form-group">
                <label for="cab-date">Date:</label>
                <input type="date" id="cab-date">
            </div>
            <a href="cabs.html"><button type="button" onclick="showResults('cabs')">Search</button></a>
        </form>
    </div>

    <!-- Search Form for Trains -->
    <div class="search-form" id="trains" style="display: none;">
        <h2>Search Trains</h2>
        <form>
            <div class="form-group">
                <label for="train-from">From:</label>
                <input type="text" id="train-from" placeholder="City or Station">
            </div>
            <div class="form-group">
                <label for="train-to">To:</label>
                <input type="text" id="train-to" placeholder="City or Station">
            </div>
            <div class="form-group">
                <label for="train-date">Date:</label>
                <input type="date" id="train-date">
            </div>
            <a href="trains.html" target="_main"><button type="button" onclick="showResults('trains')">Search</button></a>
        </form>
    </div>

    <!-- Search Form for Buses -->
    <div class="search-form" id="buses" style="display: none;">
        <h2>Search Buses</h2>
        <form>
            <div class="form-group">
                <label for="bus-from">From:</label>
                <input type="text" id="bus-from" placeholder="City or Station">
            </div>
            <div class="form-group">
                <label for="bus-to">To:</label>
                <input type="text" id="bus-to" placeholder="City or Station">
            </div>
            <div class="form-group">
                <label for="bus-date">Date:</label>
                <input type="date" id="bus-date">
            </div>
            <a href="buses.html"><button type="button" onclick="showResults('buses')">Search</button></a>
        </form>
    </div>

    <!-- Results Section -->
<!-- Update Results Section -->
<div class="results-section" id="results" style="display: none;">
    <h2>Available Options</h2>
    <div id="results-content"></div>
    <!-- Filter Options -->
    <div class="filter-options">
        <!-- Existing filter options -->
        <button class="filter-btn">Apply Filters</button>
    </div>
    <!-- Proceed to Payment Button -->
    <div class="proceed-to-payment">
        <a href="payment.html" class="proceed-btn">Proceed to Payment</a>
    </div>
</div>


    <footer class="footer">
        <p>© 2024 Travel Booking. All rights reserved.</p>
    </footer>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.search-form');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById('results').style.display = 'none'; // Hide results

            const selectedSection = document.getElementById(sectionId);
            selectedSection.style.display = 'block';
        }

    
    function showResults(type) {
        if (type === 'flights') {
            const from = document.getElementById("flight-from").value;
            const to = document.getElementById("flight-to").value;
            const date = document.getElementById("flight-departure").value;

            // Check if inputs are not empty
            if (from && to && date) {
                // Store data in localStorage
                localStorage.setItem("fromLocation", from);
                localStorage.setItem("toLocation", to);
                localStorage.setItem("travelDate", date);

                // Open Flights Page
                window.location.href = "flights.html";
            } else {
                alert("Please select From, To, and Date before searching.");
            }
        }
    }
    function showResults(type) {
        if (type === 'trains') {
            const from = document.getElementById("train-from").value;
            const to = document.getElementById("train-to").value;
            const date = document.getElementById("train-departure").value;

            // Check if inputs are not empty
            if (from && to && date) {
                // Store data in localStorage
                localStorage.setItem("fromLocation", from);
                localStorage.setItem("toLocation", to);
                localStorage.setItem("travelDate", date);

                // Open Flights Page
                window.location.href = "trains.html";
            } else {
                alert("Please select From, To, and Date before searching.");
            }
        }
    }




    </script>
    <!-- Add this script to the homepage -->
<script>
    function searchFlights() {
        const fromLocation = document.getElementById("fromInput").value;
        const toLocation = document.getElementById("toInput").value;
        window.location.href = `flights.html?from=${encodeURIComponent(fromLocation)}&to=${encodeURIComponent(toLocation)}`;
    }
    function searchtrains() {
        const fromLocation = document.getElementById("fromInput").value;
        const toLocation = document.getElementById("toInput").value;
        window.location.href = `trains.html?from=${encodeURIComponent(fromLocation)}&to=${encodeURIComponent(toLocation)}`;
    }
    

</script>

</body>
</html>
