<?php
require_once '../includes/db.php';
require_once '../includes/admin-auth.php';

requireAdminLogin();

if (!isset($_GET['id'])) {
    header("Location: parts-list.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$id]);
$part = $stmt->fetch();

if (!$part) {
    die("Part not found.");
}

$cats = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    
    $socket_type = $_POST['socket_type'] ?: null;
    $ram_type = $_POST['ram_type'] ?: null;
    $form_factor = $_POST['form_factor'] ?: null;
    $interface = $_POST['interface'] ?: null;
    $wattage = $_POST['wattage'] ?: null;
    $min_psu_wattage = $_POST['min_psu_wattage'] ?: null;

    $stmt = $pdo->prepare("UPDATE parts SET category_id=?, name=?, brand=?, model=?, price=?, socket_type=?, ram_type=?, form_factor=?, interface=?, wattage=?, min_psu_wattage=? WHERE id=?");
    if ($stmt->execute([$category_id, $name, $brand, $model, $price, $socket_type, $ram_type, $form_factor, $interface, $wattage, $min_psu_wattage, $id])) {
        header("Location: parts-list.php");
        exit();
    } else {
        $error = "Failed to update part.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Part - PCForge Admin</title>
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
        <h1>Edit Part</h1>
        <div class="card" style="max-width: 600px;">
            <form method="POST">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" id="category_select" class="form-control" required onchange="updateFields()">
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" data-slug="<?php echo $cat['slug']; ?>" <?php if($part['category_id'] == $cat['id']) echo 'selected'; ?>>
                                <?php echo $cat['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($part['name']); ?>" required>
                </div>
                <div class="d-flex gap-1">
                    <div class="form-group w-100">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($part['brand']); ?>">
                    </div>
                    <div class="form-group w-100">
                        <label>Model</label>
                        <input type="text" name="model" class="form-control" value="<?php echo htmlspecialchars($part['model']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $part['price']; ?>" required>
                </div>

                <div id="field-socket" class="form-group" style="display:none;">
                    <label>Socket Type</label>
                    <input type="text" name="socket_type" class="form-control" value="<?php echo htmlspecialchars($part['socket_type'] ?? ''); ?>">
                </div>
                <div id="field-ram" class="form-group" style="display:none;">
                    <label>RAM Type</label>
                    <input type="text" name="ram_type" class="form-control" value="<?php echo htmlspecialchars($part['ram_type'] ?? ''); ?>">
                </div>
                <div id="field-form" class="form-group" style="display:none;">
                    <label>Form Factor</label>
                    <input type="text" name="form_factor" class="form-control" value="<?php echo htmlspecialchars($part['form_factor'] ?? ''); ?>">
                </div>
                <div id="field-interface" class="form-group" style="display:none;">
                    <label>Interface</label>
                    <input type="text" name="interface" class="form-control" value="<?php echo htmlspecialchars($part['interface'] ?? ''); ?>">
                </div>
                <div id="field-wattage" class="form-group" style="display:none;">
                    <label>Wattage (W)</label>
                    <input type="number" name="wattage" class="form-control" value="<?php echo htmlspecialchars($part['wattage'] ?? ''); ?>">
                </div>
                <div id="field-min-psu" class="form-group" style="display:none;">
                    <label>Min PSU Wattage (W)</label>
                    <input type="number" name="min_psu_wattage" class="form-control" value="<?php echo htmlspecialchars($part['min_psu_wattage'] ?? ''); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update Part</button>
                <a href="parts-list.php" class="btn btn-outline">Cancel</a>
            </form>
        </div>
    </main>

    <script>
        function updateFields() {
            const select = document.getElementById('category_select');
            const option = select.options[select.selectedIndex];
            const slug = option.getAttribute('data-slug');

            document.getElementById('field-socket').style.display = 'none';
            document.getElementById('field-ram').style.display = 'none';
            document.getElementById('field-form').style.display = 'none';
            document.getElementById('field-interface').style.display = 'none';
            document.getElementById('field-wattage').style.display = 'none';
            document.getElementById('field-min-psu').style.display = 'none';

            if (slug === 'cpu') {
                document.getElementById('field-socket').style.display = 'block';
            } else if (slug === 'motherboard') {
                document.getElementById('field-socket').style.display = 'block';
                document.getElementById('field-ram').style.display = 'block';
                document.getElementById('field-form').style.display = 'block';
            } else if (slug === 'ram') {
                document.getElementById('field-ram').style.display = 'block';
            } else if (slug === 'storage') {
                document.getElementById('field-interface').style.display = 'block';
            } else if (slug === 'gpu') {
                document.getElementById('field-min-psu').style.display = 'block';
            } else if (slug === 'psu') {
                document.getElementById('field-wattage').style.display = 'block';
            }
        }
        // Init on load
        updateFields();
    </script>
</body>
</html>