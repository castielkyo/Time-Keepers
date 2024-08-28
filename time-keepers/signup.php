<?php
require 'config.php';

$error = $success = '';
$showModal = false; // Variable to control modal display

if (isset($_POST["submit"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthdate = $_POST["birthdate"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
        $showModal = true;
    } else {
        $domain = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($domain, 'MX')) {
            $error = 'Email domain does not exist.';
            $showModal = true;
        } else {
            $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
            if (mysqli_num_rows($duplicate) > 0) {
                $error = 'Email has already been taken.';
                $showModal = true;
            } else {
                if ($password == $confirmPassword) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    $query = "INSERT INTO users (firstName, lastName, birthdate, email, password) 
                              VALUES ('$firstName', '$lastName', '$birthdate', '$email', '$hashedPassword')";
                    if (mysqli_query($conn, $query)) {
                        $success = 'Sign Up Successful.';
                        $showModal = true;
                    } else {
                        $error = 'Error signing up.';
                        $showModal = true;
                    }
                } else {
                    $error = 'Password does not match.';
                    $showModal = true;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time-Keepers - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="signuppagestyle.css">
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

    <div class="signup-section d-flex align-items-center justify-content-center">
        <div class="signup-box p-4">
            <h2 class="text-center mb-4">Sign Up</h2>
            <form action="signup.php" method="post">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" required>
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-custom w-100 mt-3" name="submit">Sign Up</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php" class="text-decoration-none">Log In</a></p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($showModal): ?>
                var myModal = new bootstrap.Modal(document.getElementById('alertModal'), {
                    keyboard: false
                });
                myModal.show();
            <?php endif; ?>
        });
    </script>
</body>
</html>
