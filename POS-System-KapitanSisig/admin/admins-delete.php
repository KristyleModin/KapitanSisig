<?php
require '../config/function.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paraResult = checkParam('id');
if (is_numeric($paraResult)) {
    $adminId = validate($paraResult);

    $admin = getById('admins', $adminId);
    if ($admin['status'] == 200) {
        $adminDeleteRes = delete('admins', $adminId);
        if ($adminDeleteRes) {
            $_SESSION['message'] = 'Admin deleted.';
            header('Location: admins.php');
            exit();
        } else {
            $_SESSION['message'] = 'Something went wrong.';
            header('Location: admins.php');
            exit();
        }
    } else {
        $_SESSION['message'] = $admin['message'];
        header('Location: admins.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid ID.';
    header('Location: admins.php');
    exit();
}
?>
