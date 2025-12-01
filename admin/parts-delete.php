<?php
require_once '../includes/db.php';
require_once '../includes/admin-auth.php';

requireAdminLogin();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM parts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: parts-list.php");
exit();
?>