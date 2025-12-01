<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="text-center" style="padding: 4rem 0;">
    <h1 style="font-size: 3rem; margin-bottom: 1rem;">Build Your Dream PC</h1>
    <p style="font-size: 1.25rem; color: var(--color-text-muted); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        PCForge helps you select compatible parts, track your budget, and build the perfect custom PC step-by-step.
    </p>
    <div class="d-flex justify-between" style="justify-content: center; gap: 1rem;">
        <a href="builder.php" class="btn btn-primary" style="font-size: 1.25rem; padding: 0.75rem 2rem;">Start Building Now</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn btn-outline" style="font-size: 1.25rem; padding: 0.75rem 2rem;">Create Account</a>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-between gap-2 mt-3">
    <div class="card w-100 text-center">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">✅</div>
        <h3>Compatibility Check</h3>
        <p class="mt-1">We automatically filter out parts that don't fit your build.</p>
    </div>
    <div class="card w-100 text-center">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
        <h3>Real-time Pricing</h3>
        <p class="mt-1">See the total cost update instantly as you pick components.</p>
    </div>
    <div class="card w-100 text-center">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">💾</div>
        <h3>Save Your Builds</h3>
        <p class="mt-1">Create an account to save your configurations for later.</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>