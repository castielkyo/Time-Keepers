<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Time-Keepers - Luxury Watches</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="indexstyles.css?v=1.1">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="tklogo.png" alt="Time-Keepers" class="brand-logo"></a>
      <h3 id="logotxt">Time-Keepers</h3>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Watches</a>
          </li>
                <?php if (isset($_SESSION["login"])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo $_SESSION["email"]; ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Log Out</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Log In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php">Sign Up</a>
                            </li>
                <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <header class="hero">
    <div class="container">
      <div class="quote-section">
        <h1 class="welcome">Welcome to Time-Keepers</h1>
        <p class="quote">“A luxury watch is not just a timekeeping device; it's a statement of artistry and craftsmanship, embodying the essence of time itself."</p>
        <div class="button-container">
          <a href="#" class="btn-custom">Shop Now</a>
          <a href="#featured-brands" class="btn-featured">Featured Brands</a>
        </div>
      </div>
  </header>

  <!-- Featured Brands Section -->
  <div id="featured-brands" class="featured-brands">
    <h2>Featured Brands</h2>
    <div class="brands-container">
      <div class="brand-item">
        <div class="brand-image">
          <img src="1.jpg" alt="Brand 1">
        </div>
        <div class="brand-description">
          <p id="ap">Audemars Piguet</p>
          <p id="description">Audemars Piguet: Established in 1875, Audemars Piguet is a Swiss luxury watch manufacturer with a reputation for haute horology. The brand is known for its intricate craftsmanship and innovative designs, including the iconic Royal Oak series. Audemars Piguet combines traditional watchmaking techniques with modern technology. The brand's commitment to artistry and precision makes its watches highly coveted among collectors and enthusiasts.</p>
        </div>
      </div>
      <div class="brand-item">
        <div class="brand-image">
          <img src="2.jpg" alt="Brand 2">
        </div>
        <div class="brand-description">
          <p id="rolex">Rolex</p>
          <p id="description">Rolex: Founded in 1905, Rolex is a prestigious Swiss watchmaker renowned for its luxury timepieces. The brand is celebrated for its precision, durability, and innovative technology. Rolex watches often feature classic designs, such as the Oyster Perpetual and the Daytona, known for their robust construction and timeless aesthetics. The brand's commitment to excellence is evident in its use of high-quality materials, like 18k gold and stainless steel, and its dedication to in-house craftsmanship.</p>
        </div>
      </div>
      <div class="brand-item">
        <div class="brand-image">
          <img src="3.jpg" alt="Brand 3">
        </div>
        <div class="brand-description">
          <p id="patek">Patek Philippe</p>
          <p id="description">Patek Philippe: Established in 1839, Patek Philippe is a Swiss luxury watchmaker renowned for its exceptional craftsmanship and heritage. The brand is distinguished by its complex movements and elegant designs, such as the Calatrava and Nautilus. Patek Philippe watches are celebrated for their precision, innovation, and timeless appeal, making them highly sought after by collectors and connoisseurs. Each timepiece is a testament to the brand's commitment to quality and tradition.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <!-- About Us & Our Team -->
        <div class="col-md-4 d-flex flex-column align-items-start">
          <a href="about.php" class="footer-link btn-custom mb-3">About Us</a>
          <a href="team.php" class="footer-link btn-custom">Our Team</a>
        </div>
        <!-- Contact Us -->
        <div class="col-md-4">
          <h5>Contact Us</h5>
          <ul class="list-unstyled">
            <li>Email: contact@timekeepers.com</li>
            <li>Phone: +123 456 7890</li>
          </ul>
        </div>
        <!-- Follow Us -->
        <div class="col-md-4">
          <h5>Follow Us</h5>
          <ul class="list-unstyled d-flex flex-column">
            <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="bi bi-facebook me-2"></i>Facebook</a></li>
            <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="bi bi-instagram me-2"></i>Instagram</a></li>
            <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="bi bi-twitter me-2"></i>Twitter</a></li>
            <li><a href="#" class="text-white text-decoration-none"><i class="bi bi-telegram me-2"></i>Telegram</a></li>
          </ul>
        </div>
      </div>
      <!-- Footer Bottom -->
      <div class="row">
        <div class="col text-center mt-4">
          <p>&copy; 2024 Time-Keepers. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
