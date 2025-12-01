<?php
require_once 'includes/db.php';
require_once 'includes/user-auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if email or username exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->rowCount() > 0) {
            $error = "Email or Username is already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, username, email, password_hash) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $username, $email, $hash])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $username; // Use username as display name? Or name? Let's use username as requested context implies importance.
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

include 'includes/header.php';
?>

<div style="max-width: 400px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">Create Account</div>
        <?php if ($error): ?>
            <div style="color: #da3633; margin-bottom: 1rem; padding: 0.5rem; background: rgba(218, 54, 51, 0.1); border: 1px solid #da3633; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
        <div class="mt-2 text-center">
            Already have an account? <a href="login.php" style="color: var(--color-primary);">Login here</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>