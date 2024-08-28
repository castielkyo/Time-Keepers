<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Time-Keepers - Our Team</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="teampagestyle.css">
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

  <!-- Our Team Section -->
  <section class="our-team-section">
    <div class="container">
      <h2 class="section-title text-center mb-5">Our Team</h2>
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="team-member d-flex align-items-center">
            <img src="samar.jpg" alt="Manuelito L. Samar Jr." class="team-img">
            <div class="team-info">
              <h3 class="team-name">Manuelito L. Samar Jr.</h3>
              <p class="team-role">Main Programmer</p>
              <p class="team-description">ASADSADADASDASDADAD ASDADASDADASDADADA </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="team-member d-flex align-items-center">
            <img src="team-member2.jpg" alt="Mary Anne Pagota" class="team-img">
            <div class="team-info">
              <h3 class="team-name">Mary Anne Pagota</h3>
              <p class="team-role">Documentator</p>
              <p class="team-description">JSADADADADADADASDDADASD</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="team-member d-flex align-items-center">
            <img src="cha.png" alt="Charmaine Funtilar" class="team-img">
            <div class="team-info">
              <h3 class="team-name">Charmaine Funtilar</h3>
              <p class="team-role">Documentator</p>
              <p class="team-description">ADSASDADASDASDSADASD</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="team-member d-flex align-items-center">
            <img src="maryv.png" alt="Mary Lee Vibar" class="team-img">
            <div class="team-info">
              <h3 class="team-name">Mary Lee Vibar</h3>
              <p class="team-role">Documentator</p>
              <p class="team-description">ASDADSADADADADA SADASDADA </p>
            </div>
          </div>
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
