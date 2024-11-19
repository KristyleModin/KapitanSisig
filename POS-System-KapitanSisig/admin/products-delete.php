<?php 
require '../config/function.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paramResultId = checkParam('id');
if (is_numeric($paramResultId)) {
    $productId = validate($paramResultId);

    $product = getById('products', $productId);

    if ($product['status'] == 200) {
        $productDeleteRes = delete('products', $productId);
        if ($productDeleteRes) {
            $deleteImage = "../" . $product['data']['image'];
            if (file_exists($deleteImage)) {
                unlink($deleteImage);
            }
            $_SESSION['message'] = 'Product deleted successfully!';
            header('Location: products.php');
            exit();
        } else {
            $_SESSION['message'] = 'Something went wrong.';
            header('Location: products.php');
            exit();
        }
    } else {
        $_SESSION['message'] = $product['message'];
        header('Location: products.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid ID provided.';
    header('Location: products.php');
    exit();
}
?>
