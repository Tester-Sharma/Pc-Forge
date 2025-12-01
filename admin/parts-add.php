<?php
require_once '../includes/db.php';
require_once '../includes/admin-auth.php';

requireAdminLogin();

$cats = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    
    // Optional fields
    $socket_type = $_POST['socket_type'] ?: null;
    $ram_type = $_POST['ram_type'] ?: null;
    $form_factor = $_POST['form_factor'] ?: null;
    $interface = $_POST['interface'] ?: null;
    $wattage = $_POST['wattage'] ?: null;
    $min_psu_wattage = $_POST['min_psu_wattage'] ?: null;

    $stmt = $pdo->prepare("INSERT INTO parts (category_id, name, brand, model, price, socket_type, ram_type, form_factor, interface, wattage, min_psu_wattage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$category_id, $name, $brand, $model, $price, $socket_type, $ram_type, $form_factor, $interface, $wattage, $min_psu_wattage])) {
        header("Location: parts-list.php");
        exit();
    } else {
        $error = "Failed to add part.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Part - PCForge Admin</title>
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
        <h1>Add New Part</h1>
        <div class="card" style="max-width: 600px;">
            <form method="POST">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" id="category_select" class="form-control" required onchange="updateFields()">
                        <option value="">Select Category</option>
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" data-slug="<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Name (Full Title)</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="d-flex gap-1">
                    <div class="form-group w-100">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control">
                    </div>
                    <div class="form-group w-100">
                        <label>Model</label>
                        <input type="text" name="model" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <!-- Dynamic Fields -->
                <div id="field-socket" class="form-group" style="display:none;">
                    <label>Socket Type (e.g., LGA1700, AM4)</label>
                    <input type="text" name="socket_type" class="form-control">
                </div>
                <div id="field-ram" class="form-group" style="display:none;">
                    <label>RAM Type (e.g., DDR4, DDR5)</label>
                    <input type="text" name="ram_type" class="form-control">
                </div>
                <div id="field-form" class="form-group" style="display:none;">
                    <label>Form Factor (e.g., ATX, mATX)</label>
                    <input type="text" name="form_factor" class="form-control">
                </div>
                <div id="field-interface" class="form-group" style="display:none;">
                    <label>Interface (e.g., SATA, NVMe)</label>
                    <input type="text" name="interface" class="form-control">
                </div>
                <div id="field-wattage" class="form-group" style="display:none;">
                    <label>Wattage (W)</label>
                    <input type="number" name="wattage" class="form-control">
                </div>
                <div id="field-min-psu" class="form-group" style="display:none;">
                    <label>Min PSU Wattage (W)</label>
                    <input type="number" name="min_psu_wattage" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save Part</button>
                <a href="parts-list.php" class="btn btn-outline">Cancel</a>
            </form>
        </div>
    </main>

    <script>
        function updateFields() {
            const select = document.getElementById('category_select');
            const option = select.options[select.selectedIndex];
            const slug = option.getAttribute('data-slug');

            // Hide all first
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
    </script>
</body>
</html>