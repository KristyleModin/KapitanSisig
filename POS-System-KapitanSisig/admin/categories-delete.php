<?php
require '../config/function.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if 'id' parameter is set and is numeric
$paramResultId = checkParam('id');
if (is_numeric($paramResultId)) {
    $categoryId = validate($paramResultId);

    $category = getById('categories', $categoryId);

    if ($category['status'] == 200) {
        $categoryDeleteRes = delete('categories', $categoryId);
        if ($categoryDeleteRes) {
            $_SESSION['message'] = 'Category deleted successfully!';
            header('Location: categories.php');
            exit();
        } else {
            $_SESSION['message'] = 'Something went wrong.';
            header('Location: categories.php');
            exit();
        }
    } else {
        $_SESSION['message'] = $category['message'];
        header('Location: categories.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid ID.';
    header('Location: categories.php');
    exit();
}
?>
