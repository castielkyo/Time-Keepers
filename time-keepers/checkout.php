<?php
session_start();
include('config.php'); // Ensure your database connection is established here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
    $cart = json_decode($_POST['cart'], true);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        foreach ($cart as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Check stock
            $stockQuery = "SELECT stock FROM products WHERE id = '$productId'";
            $stockResult = mysqli_query($conn, $stockQuery);
            $stockRow = mysqli_fetch_assoc($stockResult);
            if ($stockRow['stock'] < $quantity) {
                throw new Exception("Not enough stock for product ID $productId");
            }

            // Update stock
            $updateStockQuery = "UPDATE products SET stock = stock - $quantity WHERE id = '$productId'";
            if (!mysqli_query($conn, $updateStockQuery)) {
                throw new Exception("Failed to update stock for product ID $productId");
            }

            // Insert into orders table
            $insertOrderQuery = "INSERT INTO orders (email, product_id, quantity, price, appointment_date) VALUES ('$email', '$productId', '$quantity', '$price', '$appointmentDate')";
            if (!mysqli_query($conn, $insertOrderQuery)) {
                throw new Exception("Failed to insert order for product ID $productId");
            }
        }

        // Commit transaction
        mysqli_commit($conn);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
