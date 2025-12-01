<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCForge - Custom PC Builder</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">🔥 <span>PCForge</span></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="builder.php">Start Build</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="my-builds.php">My Builds</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php" class="btn btn-primary" style="color: white; padding: 0.5rem 1rem;">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>