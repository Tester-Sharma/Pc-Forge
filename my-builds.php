<?php
require_once 'includes/db.php';
require_once 'includes/user-auth.php';

requireLogin();

$stmt = $pdo->prepare("
    SELECT b.*, 
           cpu.name as cpu_name, 
           gpu.name as gpu_name,
           mobo.name as mobo_name
    FROM builds b
    LEFT JOIN parts cpu ON b.cpu_id = cpu.id
    LEFT JOIN parts gpu ON b.gpu_id = gpu.id
    LEFT JOIN parts mobo ON b.motherboard_id = mobo.id
    WHERE b.user_id = ?
    ORDER BY b.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$builds = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">My Saved Builds</div>
    
    <?php if (count($builds) === 0): ?>
        <p class="text-center p-3">You haven't saved any builds yet. <a href="builder.php" style="color: var(--color-primary);">Start building!</a></p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Core Specs</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($builds as $build): ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($build['created_at'])); ?></td>
                        <td>
                            <div style="font-size: 0.9rem;">
                                <strong>CPU:</strong> <?php echo htmlspecialchars($build['cpu_name'] ?? 'N/A'); ?><br>
                                <strong>GPU:</strong> <?php echo htmlspecialchars($build['gpu_name'] ?? 'N/A'); ?><br>
                                <strong>Mobo:</strong> <?php echo htmlspecialchars($build['mobo_name'] ?? 'N/A'); ?>
                            </div>
                        </td>
                        <td style="font-weight: bold;">₹<?php echo number_format($build['total_price']); ?></td>
                        <td>
                            <a href="export-pdf.php?id=<?php echo $build['id']; ?>" target="_blank" class="btn btn-outline" style="font-size: 0.8rem;">Export PDF</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>