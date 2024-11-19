<?php
require '../config/function.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if 'id' parameter is set and is numeric
$paraResult = checkParam('id');
if (is_numeric($paraResult)) {
    $supplierId = validate($paraResult);

    // Fetch supplier data
    $supplier = getById('suppliers', $supplierId);

    if ($supplier['status'] == 200) {
        // Delete the supplier
        $supplierDeleteRes = delete('suppliers', $supplierId);
        if ($supplierDeleteRes) {
            $_SESSION['message'] = 'Supplier Deleted.';
            header('Location: suppliers.php');
            exit();
        } else {
            $_SESSION['message'] = 'Something Went Wrong!';
            header('Location: suppliers.php');
            exit();
        }
    } else {
        $_SESSION['message'] = $supplier['message'];
        header('Location: suppliers.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid ID.';
    header('Location: suppliers.php');
    exit();
}
?>
