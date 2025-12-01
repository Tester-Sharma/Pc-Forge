<?php
require_once '../includes/db.php';
require_once '../includes/admin-auth.php';

requireAdminLogin();

// Fetch categories for filter
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();

// Filter logic
$category_id = isset($_GET['category']) ? $_GET['category'] : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT p.*, c.name as category_name FROM parts p JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if ($category_id) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_id;
}

if ($search) {
    $sql .= " AND (p.name LIKE ? OR p.brand LIKE ? OR p.model LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$parts = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Parts - PCForge Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="dashboard.php">🔥 <span>PCForge Admin</span></a>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="parts-list.php" class="active">Manage Parts</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="d-flex justify-between align-center mb-2">
            <h1>Parts Inventory</h1>
            <a href="parts-add.php" class="btn btn-primary">Add New Part</a>
        </div>

        <div class="card">
            <form method="GET" class="d-flex gap-1 mb-2">
                <select name="category" class="form-control" style="width: 200px;">
                    <option value="">All Categories</option>
                    <?php foreach ($cats as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if($category_id == $cat['id']) echo 'selected'; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="search" class="form-control" placeholder="Search parts..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-outline">Filter</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Brand / Model</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parts as $part): ?>
                        <tr>
                            <td><?php echo $part['id']; ?></td>
                            <td><?php echo $part['category_name']; ?></td>
                            <td>
                                <strong><?php echo $part['brand']; ?></strong> <?php echo $part['model']; ?><br>
                                <small><?php echo $part['name']; ?></small>
                            </td>
                            <td>₹<?php echo number_format($part['price']); ?></td>
                            <td>
                                <a href="parts-edit.php?id=<?php echo $part['id']; ?>" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>
                                <a href="parts-delete.php?id=<?php echo $part['id']; ?>" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>