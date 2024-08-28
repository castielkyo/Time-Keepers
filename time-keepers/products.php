<?php
session_start();
include('config.php'); // Ensure your database connection is established here

// Check if the user is logged in
if (!isset($_SESSION["login"])) {
    header("Location: login.php?notification=login_required");
    exit();
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Time-Keepers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="productpagestyle.css">
    <style>
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            max-width: 350px; /* Adjust size as needed */
            margin: 0 auto; /* Centered the card */
            height: 200px; /* Adjust the height to your needs */
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1; /* Allows the card body to expand and take available space */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Align content to spread out */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .add-to-cart {
            background-color: #e0b877; 
            color: #fff; 
            border: none; 
            transition: background-color 0.3s;
        }

        .add-to-cart:hover {
            background-color: #d8a76b;
            cursor: pointer;
        }

        .card-body img {
            max-height: 300px; /* Increased height */
            object-fit: cover;
            background-color: black; /* Black background */
        }

        .cart-icon {
            font-size: 1.5rem;
            color: #fff;
            cursor: pointer;
        }

        .cart-icon:hover {
            color: #e0b877;
        }
    </style>
</head>
<body>
<div id="notification1" class="notification hidden">Notification message</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('notification1')) {
        const notificationType = urlParams.get('notification1');
        let message = '';

        if (notificationType === 'login_required') {
            message = 'You need to log in to access this page.';
        }

        if (message) {
            showNotification1(message, true);
        }
    }

    function showNotification1(message, isError = false) {
        const notification1 = document.getElementById('notification1');
        notification1.textContent = message;
        notification1.className = 'notification1'; // Reset class
        if (isError) {
            notification1.classList.add('error');
        } else {
            notification1.classList.remove('error');
        }
        notification1.style.display = 'block'; // Show the notification

        setTimeout(() => {
            showNotification1.style.display = 'none'; // Hide after 3 seconds
        }, 3000);
    }
});
</script>

<div id="notification" class="notification hidden">Added to cart successfully!</div>
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
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">
                            <i class="bi bi-cart cart-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Products Section -->
    <div class="about-us-background">
        <div class="container mt-5">
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="products/<?php echo $row['image']; ?>" class="img-fluid rounded-start" alt="<?php echo $row['name']; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                        <p class="card-text">₱<?php echo number_format($row['price'], 2); ?></p>
                                        <p class="card-text">Available in stock: <?php echo $row['stock']; ?> </p>
                                        <button class="btn add-to-cart" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>" data-stock="<?php echo $row['stock']; ?>" data-image="<?php echo $row['image']; ?>">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

 <!-- Cart Modal with adjusted container -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Cart Section -->
                    <div class="col-md-6 cart-container">
                        <h5>Cart Items</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <!-- Cart items will be injected here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Checkout Form Section -->
                    <div class="col-md-6">
                        <h5>Checkout Form</h5>
                        <form id="checkoutForm">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
                            </div>
                            <div class="mb-3">
                                <label for="appointmentDate" class="form-label">Appointment Date</label>
                                <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const cart = {};

    function updateCartModal() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';
        let total = 0;

        Object.values(cart).forEach(item => {
            total += item.price * item.quantity;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <img src="products/${item.image}" class="img-fluid" style="max-width: 100px;" alt="${item.name}"><br>
                    ${item.name}
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.id}', -1)">-</button>
                    ${item.quantity}
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.id}', 1)">+</button>
                </td>
                <td>₱${(item.price * item.quantity).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart('${item.id}')">Remove</button>
                </td>
            `;
            cartItemsContainer.appendChild(row);
        });

        const totalRow = document.createElement('tr');
        totalRow.innerHTML = `
            <td colspan="2"><strong>Total</strong></td>
            <td><strong>₱${total.toFixed(2)}</strong></td>
            <td></td>
        `;
        cartItemsContainer.appendChild(totalRow);
    }

    window.updateQuantity = function(id, change) {
        if (!cart[id]) return;

        const item = cart[id];
        item.quantity += change;

        if (item.quantity <= 0) {
            delete cart[id];
        } else if (item.quantity > item.stock) {
            showNotification(`Cannot add more than ${item.stock} items. Only ${item.stock} in stock.`, true);
            item.quantity = item.stock;
        }

        updateCartModal();
    };

    window.removeFromCart = function(id) {
        delete cart[id];
        updateCartModal();
    };

    function showNotification(message, isError = false) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = 'notification'; // Reset class
        if (isError) {
            notification.classList.add('error');
        } else {
            notification.classList.remove('error');
        }
        notification.style.display = 'block'; // Show the notification

        setTimeout(() => {
            notification.style.display = 'none'; // Hide after 3 seconds
        }, 3000);
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const stock = parseInt(this.dataset.stock);
            const image = this.dataset.image;

            if (stock <= 0) {
                showNotification('Adding to cart failed. No stocks available.', true);
                return; // Prevent adding to cart
            }

            if (!cart[id]) {
                cart[id] = { id, name, price, stock, image, quantity: 1 };
            } else {
                const item = cart[id];
                if (item.quantity < item.stock) {
                    item.quantity++;
                } else {
                    showNotification(`Cannot add more than ${item.stock} items. Only ${item.stock} in stock.`, true);
                    return; // Prevent adding more items than in stock
                }
            }

            updateCartModal();
            showNotification('Added to cart successfully!');
        });
    });

    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault();

        if (Object.keys(cart).length === 0) {
            showNotification('Your cart is empty. Please add items to your cart before checking out.', true);
            return; // Prevent form submission
        }

        var formData = new FormData(this);
        formData.append('cart', JSON.stringify(cart)); // Append cart data

        fetch('checkout.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Order successfully placed!');
                setTimeout(() => {
                    window.location.href = 'products.php'; // Redirect to products page
                }, 3000);
            } else {
                showNotification('Error during checkout. Please try again.', true);
            }
        })
        .catch(error => {
            showNotification('Error during checkout. Please try again.', true);
            console.error('Error:', error);
        });
    });
});


</script>
</body>
</html>
