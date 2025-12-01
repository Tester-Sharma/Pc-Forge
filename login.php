<?php
require_once 'includes/db.php';
require_once 'includes/user-auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}

include 'includes/header.php';
?>

<div style="max-width: 400px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">Login</div>
        <?php if ($error): ?>
            <div style="color: #da3633; margin-bottom: 1rem; padding: 0.5rem; background: rgba(218, 54, 51, 0.1); border: 1px solid #da3633; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-2 text-center">
            Don't have an account? <a href="register.php" style="color: var(--color-primary);">Sign up here</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>