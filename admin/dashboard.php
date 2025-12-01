<?php
require_once '../includes/db.php';
require_once '../includes/admin-auth.php';

requireAdminLogin();

// Stats
$parts_count = $pdo->query("SELECT COUNT(*) FROM parts")->fetchColumn();
$users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$builds_count = $pdo->query("SELECT COUNT(*) FROM builds")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - PCForge</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="dashboard.php">🔥 <span>PCForge Admin</span></a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="parts-list.php">Manage Parts</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Dashboard</h1>
        <div class="d-flex gap-2 mt-3">
            <div class="card w-100 text-center">
                <h3>Total Parts</h3>
                <div style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?php echo $parts_count; ?></div>
            </div>
            <div class="card w-100 text-center">
                <h3>Registered Users</h3>
                <div style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?php echo $users_count; ?></div>
            </div>
            <div class="card w-100 text-center">
                <h3>Total Builds Saved</h3>
                <div style="font-size: 2rem; font-weight: bold; color: var(--color-primary);"><?php echo $builds_count; ?></div>
            </div>
        </div>
        
        <div class="mt-3">
            <h3>Quick Actions</h3>
            <div class="d-flex gap-2 mt-1">
                <a href="parts-add.php" class="btn btn-primary">Add New Part</a>
                <a href="parts-list.php" class="btn btn-outline">View All Parts</a>
            </div>
        </div>
    </main>
</body>
</html>