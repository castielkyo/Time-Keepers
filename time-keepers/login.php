<?php
session_start();
require 'config.php';

// Set timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

$error = ''; // Initialize error variable
$success = ''; // Initialize success variable



if (isset($_POST["submit"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    // Query to select user by email
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        $_SESSION["email"] = $row["email"];

        // Record login time in customer_logs
        $login_time = date('Y-m-d H:i:s');
        $insert_log = "INSERT INTO customer_logs (email, login_time) VALUES ('$email', '$login_time')";
        mysqli_query($conn, $insert_log);

        // Set success message
        $success = 'Successfully logged in!';
        $redirect = true;
    } else {
        // Set error message
        $error = 'Invalid email or password.';
        $redirect = false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time-Keepers - Log In</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="loginpagestyles.css">
    <!-- Custom Modal CSS -->
<style>
        /* Base Styles for Modal */
        .modal-content {
            background-color: #343a40; /* Dark background for the modal */
            color: #ffffff; /* White text color */
            border-radius: 8px; /* Rounded corners */
            border: none; /* Remove border */
        }

        /* Modal Animation Styles */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        .modal.fade .modal-dialog {
            animation: fadeIn 0.3s ease-out;
        }

        .modal.fade.show .modal-dialog {
            animation: fadeOut 0.3s ease-in;
        }

        /* Checkmark and Error Icons */
        .modal-content .icon {
            font-size: 3rem;
            margin: 0 auto;
            display: block;
        }

        .modal-content .icon-check {
            color: #28a745; /* Green for success */
        }

        .modal-content .icon-error {
            color: #dc3545; /* Red for error */
        }

        .modal-header {
            border-bottom: none; /* Remove border */
        }

        .modal-footer {
            border-top: none; /* Remove border */
        }

        /* Button Styles */
        .modal-footer .btn-secondary {
            background-color: #6c757d; /* Gray button color */
            border-color: #6c757d; /* Border color */
        }

        /* Additional Padding */
        .modal-body {
            padding: 2rem; /* Add padding */
        }
</style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Form Section -->
    <div class="login-section d-flex align-items-center justify-content-center">
        <div class="login-box p-4">
            <h2 class="text-center mb-4">Log In</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" id="labels" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" id="labels" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none">Forgot password?</a>
                </div>
                <button type="submit" name="submit" class="btn btn-custom w-100 mt-3">Log In</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="signup.php" class="text-decoration-none">Sign Up</a></p>
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

    <!-- Alert Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">
                        <?php echo !empty($error) ? 'Error' : 'Success'; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <span class="icon <?php echo !empty($error) ? 'icon-error' : 'icon-check'; ?>">
                        <?php echo !empty($error) ? '❌' : '✔️'; ?>
                    </span>
                    <p><?php echo !empty($error) ? $error : $success; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS for Modal Trigger -->
    <script>
    window.onload = function() {
        <?php if (!empty($error) || !empty($success)): ?>
            var myModal = new bootstrap.Modal(document.getElementById('alertModal'), {
                keyboard: false
            });
            myModal.show();

            // Redirect to index.php after modal is closed, but only if login was successful
            if (<?php echo json_encode($redirect); ?>) {
                document.getElementById('alertModal').addEventListener('hidden.bs.modal', function (e) {
                    window.location.href = 'index.php';
                });
            }
        <?php endif; ?>
    };
    </script>
</body>
</html>
