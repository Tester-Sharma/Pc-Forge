<?php
// Check if admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Redirect if not admin
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>