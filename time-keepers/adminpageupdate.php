<?php
@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'products/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_stock)){
        $message[] = 'Please fill out all fields!';
    } else {
        $update_data = "UPDATE products SET name='$product_name', price='$product_price', stock='$product_stock'";
        if (!empty($product_image)) {
            $update_data .= ", image='$product_image'";
        }
        $update_data .= " WHERE id = '$id'";
        $upload = mysqli_query($conn, $update_data);

        if($upload){
            if (!empty($product_image)) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
            }
            header('location:adminpage.php');
        } else {
            $message[] = 'Could not update the product!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href ="adminstyles.css" rel="stylesheet">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}
?>

<div class="container">
    <div class="admin-product-form-container centered">
        <?php
        $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
        while($row = mysqli_fetch_assoc($select)){
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <h3 class="title">Update the Product</h3>
            <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Enter Product Name">
            <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter Product Price">
            <input type="number" min="0" class="box" name="product_stock" value="<?php echo $row['stock']; ?>" placeholder="Enter Product Stock">
            <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
            <input type="submit" value="Update Product" name="update_product" class="btn">
            <a href="adminpage.php" class="btn">Go Back!</a>
        </form>
        <?php }; ?>
    </div>
</div>

</body>
</html>
