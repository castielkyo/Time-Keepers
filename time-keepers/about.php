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
  <link rel="stylesheet" href="aboutpagestyle.css">
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

  <!-- About Page Content -->
  <section class="about-us-background">
    <div class="container">
      <div class="row about-us-box">
        <div class="col-md-6">
          <img src="Watch-PNG-Clipart.png" alt="About Us" class="img-fluid"> <!-- Replace with your image -->
        </div>
        <div class="col-md-6">
          <h1 class="about-us-title">About Us</h1>
          <p class="about-us-description">Welcome to Time-Keepers, where we offer a curated collection of luxury brand watches. Our selection features only the finest timepieces from world-renowned brands, combining craftsmanship and elegance to create exceptional watches for discerning collectors and fashion enthusiasts.

        At Time-Keepers, we are dedicated to helping you find the perfect watch that complements your style and stands the test of time. Our knowledgeable team is here to provide personalized service, ensuring a satisfying and memorable experience in luxury timekeeping.</p>
        </div>
      </div>
    </div>
  </section>

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