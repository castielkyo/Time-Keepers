<?php
@include 'config.php';

// Add Product Functionality
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'products/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_stock) || empty($product_image)) {
        $message[] = 'Please fill out all fields';
    } else {
        $insert = "INSERT INTO products (name, price, stock, image) VALUES ('$product_name', '$product_price', '$product_stock', '$product_image')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
}

// Update Product Functionality
if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'products/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_stock)) {
        $message[] = 'Please fill out all fields!';
    } else {
        $update_data = "UPDATE products SET name='$product_name', price='$product_price', stock='$product_stock'";
        if (!empty($product_image)) {
            $update_data .= ", image='$product_image'";
        }
        $update_data .= " WHERE id = '$id'";
        $upload = mysqli_query($conn, $update_data);

        if ($upload) {
            if (!empty($product_image)) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
            }
            header('location: adminpage.php');
        } else {
            $message[] = 'Could not update the product!';
        }
    }
}

// Delete Product Functionality
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM products WHERE id = '$id'";
    $delete = mysqli_query($conn, $delete_query);

    if ($delete) {
        header('location: adminpage.php');
    } else {
        $message[] = 'Could not delete the product!';
    }
}

$select = mysqli_query($conn, "SELECT * FROM products");

// Order Histories Query
$order_histories_query = "
    SELECT 
        email,
        product_id,
        price,
        quantity,
        appointment_date AS appointment_date,
        created_at AS order_date
    FROM 
        orders
    ORDER BY 
        created_at DESC
";
$order_histories_result = mysqli_query($conn, $order_histories_query);

// Customer Logs Query
$customer_logs_query = "
    SELECT 
        email,
        login_time,
        logout_time
    FROM 
        customer_logs
    ORDER BY 
        login_time DESC
";
$customer_logs_result = mysqli_query($conn, $customer_logs_query);

// Registered Users Query
$registered_users_query = "
    SELECT 
        firstName,
        lastName,
        email
    FROM 
        users
";
$registered_users_result = mysqli_query($conn, $registered_users_query);
?>

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="adminpagestyles.css" rel="stylesheet">
    <title>Admin Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Impact', sans-serif;
            background: #333;
        }

        h1 {
            color: #e0b877;
        }
        
        p {
            color: white;

        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: black;
            color: white;
            padding: 2rem;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .sidebar a:hover {
            background: white;
        }

        .sidebar .active {
            background: #e0b877;
        }

        .content {
            margin-left: 270px; /* Account for sidebar width */
            padding: 2rem;
        }

        .tab-content {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 2rem;
            border-radius: 0.5rem;
        }

        .tab-content h5 {
            margin-bottom: 1.5rem;
        }

        .modal-content {
            background-color: #333;
            color: white;
        }

        .modal-header, .modal-body, .modal-footer {
            border-color: #444;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-200px);
            }

            .content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        @media (max-width: 576px) {
            .admin-panel-header h1 {
                font-size: 2.5rem;
            }

            .admin-panel-header p {
                font-size: 1.4rem;
            }
        }

        .btn-primary {
            background-color: #e0b877;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #d2a465;
        }

    </style>
</head>
<body>

<div class="admin-panel-header">
    <h1>Time-Keepers</h1>
    <p>Select an option from the sidebar to manage products.</p>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-white fs-1">Admin Panel</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" id="inventory-tab" data-bs-toggle="tab" href="#inventoryTab">
                <i class="fas fa-box"></i> Products Inventory
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="addProduct-tab" data-bs-toggle="tab" href="#addProductTab">
                <i class="fas fa-plus-circle"></i> Add Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="registeredUsers" data-bs-toggle="tab" href="#registeredUsersTab">
                <i class="fas fa-users"></i> Registered Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="customerLogs-tab" data-bs-toggle="tab" href="#customerLogsTab">
                <i class="fas fa-users"></i> Customer Logs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="orderHistories-tab" data-bs-toggle="tab" href="#orderHistoriesTab">
                <i class="fas fa-receipt"></i> Order Histories
            </a>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="content">
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="alert alert-info">' . $msg . '</div>';
        }
    }
    ?>

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- Products Inventory Tab -->
        <div class="tab-pane fade show active" id="inventoryTab" role="tabpanel">
            <h5>Products Inventory</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><img src="products/<?php echo htmlspecialchars($row['image']); ?>" height="100" alt=""></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>₱<?php echo htmlspecialchars($row['price']); ?>/-</td>
                        <td><?php echo htmlspecialchars($row['stock']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateProductModal" data-id="<?php echo $row['id']; ?>" data-name="<?php echo htmlspecialchars($row['name']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" data-stock="<?php echo htmlspecialchars($row['stock']); ?>" data-image="<?php echo htmlspecialchars($row['image']); ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="adminpage.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Add Product Tab -->
        <div class="tab-pane fade" id="addProductTab" role="tabpanel">
            <h5>Add a New Product</h5>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" class="form-control mb-2" name="product_name" placeholder="Enter Product Name" required>
                <input type="number" class="form-control mb-2" name="product_price" placeholder="Enter Product Price" step="0.01" required>
                <input type="number" class="form-control mb-2" name="product_stock" placeholder="Enter Product Stock" required>
                <input type="file" class="form-control mb-2" name="product_image" accept="image/*" required>
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <!-- Registered Users Tab -->
        <div class="tab-pane fade" id="registeredUsersTab" role="tabpanel">
            <h5>Registered Users</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($user = mysqli_fetch_assoc($registered_users_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                        <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Customer Logs Tab -->
        <div class="tab-pane fade" id="customerLogsTab" role="tabpanel">
            <h5>Customer Logs</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($log = mysqli_fetch_assoc($customer_logs_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['email']); ?></td>
                        <td><?php echo htmlspecialchars($log['login_time']); ?></td>
                        <td><?php echo htmlspecialchars($log['logout_time']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Order Histories Tab -->
        <div class="tab-pane fade" id="orderHistoriesTab" role="tabpanel">
            <h5>Order Histories</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Product ID</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Appointment Date</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($order = mysqli_fetch_assoc($order_histories_result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_id']); ?></td>
                        <td>₱<?php echo htmlspecialchars($order['price']); ?>/-</td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Product Modal -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="text" class="form-control mb-2" name="product_name" id="product_name" placeholder="Product Name" required>
                    <input type="number" class="form-control mb-2" name="product_price" id="product_price" placeholder="Product Price" step="0.01" required>
                    <input type="number" class="form-control mb-2" name="product_stock" id="product_stock" placeholder="Product Stock" required>
                    <input type="file" class="form-control mb-2" name="product_image" id="product_image" accept="image/*">
                    <img id="product_image_preview" src="" alt="" style="width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_product" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var updateProductModal = document.getElementById('updateProductModal');
        updateProductModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var price = button.getAttribute('data-price');
            var stock = button.getAttribute('data-stock');
            var image = button.getAttribute('data-image');

            var modalId = updateProductModal.querySelector('#product_id');
            var modalName = updateProductModal.querySelector('#product_name');
            var modalPrice = updateProductModal.querySelector('#product_price');
            var modalStock = updateProductModal.querySelector('#product_stock');
            var modalImage = updateProductModal.querySelector('#product_image_preview');

            modalId.value = id;
            modalName.value = name;
            modalPrice.value = price;
            modalStock.value = stock;
            if (image) {
                modalImage.src = 'products/' + image;
            } else {
                modalImage.src = '';
            }
        });
    });
</script>

</body>
</html>

